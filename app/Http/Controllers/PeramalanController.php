<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDetail;
use PDF;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PeramalanController extends Controller
{
    public function index()
    {
        $productLists = Produk::select('id_produk', 'nama_produk')
            ->get();

        return view('peramalan.index', ['productLists' => $productLists]);
    }

    private static function calculateMovingAverage($productId, $startDate, $endDate, $period)
    {
        // Menghitung jumlah bulan antara tanggal awal dan tanggal akhir
        $startMonth = Carbon::createFromFormat('Y-m', $startDate)->startOfMonth(); 
        $endMonth = Carbon::createFromFormat('Y-m', $endDate)->endOfMonth();

        // Assign variable bulan saat ini yang akan dilooping dari awal bulan dipilih sampai bulan akhir.
        $forecastData = []; // Deklarasi varible forecastData as an array.
        $currentMonth = $startMonth->copy(); // fungsi copy untuk duplikat value pewaktuan dari carbon.
        while ($currentMonth <= $endMonth) {
            // Mengambil data penjualan_detail berdasarkan produk dan rentang tanggal
            $monthNow = $currentMonth->copy();
            $monthStart = $monthNow->startOfMonth()->format('Y-m-d H:i:s'); // 2022-01-01 00:00:00
            $monthEnd = $monthNow->endOfMonth()->format('Y-m-d H:i:s'); // 2022-01-31 23:59:59

            // Get data jumlah penjualan item (barang) antara monthStart dan monthEnd
            $query = PenjualanDetail::select('jumlah')
                ->where('id_produk', $productId)
                ->whereBetween('created_at', [$monthStart, $monthEnd]);

            // Assign variable value.
            $forecastData[] = [
                'month' => $currentMonth->format('Y-m'), // 2022-01
                'actual_sales' => $query->sum('jumlah') ?? 0, // ternary operator
                'is_actual_data' => $query->exists(), // returning true or false
                'forecast_sales' => 0 // default -> nantinya akan diubah oleh code dibawah.
            ];

            // Tambahkan 1 bulan ke bulan saat ini
            $currentMonth->addMonth(); // addMonth adalah salah satu fungsi dari Carbon.
        }

        // Core forecasting code.
        foreach ($forecastData as $index => $data) {
            // indexing awal untuk 0 sesuai pilihan periode dari user.
            if ($index + 1 <= $period) {
                // Jika index + 1 kurang dari sama dengan period yang dipilih user, 
                // maka assign nilai forecastnya menjadi 0
                $forecastData[$index]['forecast_sales'] = 0; 
            } else {
                // Deklarasi awal variable sum
                $sum = 0;

                // Looping perhitungan forecastnya.
                for ($j = $index - $period + 1; $j <= $index; $j++) {
                    if ($forecastData[$j - 1]['is_actual_data']) {
                        $sum += $forecastData[$j - 1]['actual_sales'];
                    } else {
                        $sum += $forecastData[$j - 1]['forecast_sales'];
                    }
                }

                // fungsi round untuk membatasi jumlah digit dibelakang koma.
                $forecastData[$index]['forecast_sales'] = round($sum / $period, 2);
            }
        }

        return $forecastData;
    }

    private static function calculateMAPE($actual_sales, $forecast_sales, $index, $period) 
    {
        if ($index + 1 <= $period) {
            return 0;
        } else {
            // return abs((($actual_sales-$forecast_sales)/$actual_sales)*100)/$period; 
            return abs((($actual_sales-$forecast_sales)/$actual_sales)*100); // Rumus utama MAPE
        }
    }

    public function renderChartData($forecast)
    {
        $chartLabel = [];
        $actualData = [];
        $forecastData = [];
        
        $forecast->each(function ($item) use (&$chartLabel, &$actualData, &$forecastData) {
            array_push($chartLabel, $item['month']);
            array_push($forecastData, (float) $item['forecast_sales']);
            array_push($actualData, (float) $item['actual_sales']);
        });
        
        // css untuk chart
        $data = array(
            [
                'label'=> 'Actual Sales',
                'data'=> $actualData,
                'fillColor' => 'rgba(60,141,188,0.9)',
                'strokeColor' => 'rgba(60,141,188,0.8)',
                'pointColor' => '#3b8bba',
                'pointStrokeColor' => 'rgba(60,141,188,1)',
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => 'rgba(60,141,188,1)',
            ],
            [
                'label'=> 'Forecast Sales',
                'data'=> $forecastData,
                'fillColor' => 'rgba(210, 214, 222, 0.7)',
                'strokeColor' => 'rgba(210, 214, 222, 0.7)',
                'pointColor' => 'rgba(210, 214, 222, 0.7)',
                'pointStrokeColor' => '#c1c7d1',
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => 'rgba(220,220,220,0.7)',
            ],
        );

        return array('labels' => $chartLabel, 'datasets' => $data);
    }

    public function hitung(Request $request)
    {
        $data = $request->_data;

        $id_produk = $data['id_produk'];
        $periode = $data['periode'];
        $bulan_awal = $data['bulan_awal'];
        $bulan_akhir = $data['bulan_akhir'];

        $forecast = self::calculateMovingAverage($id_produk, $bulan_awal, $bulan_akhir, $periode);
        // menggunakan mapping collection dari fungsi laravel
        $forecast = collect($forecast)->map(function ($item, $index) use ($periode) {
            $month = Carbon::createFromFormat('Y-m', $item['month'])
                ->locale('id')
                ->settings(['formatFunction' => 'translatedFormat']);
            $actual_sales = $item['actual_sales'];
            $forecast_sales = $item['forecast_sales'];

            return collect([
                'month' => $month->format('F Y'), // Januari 2022
                'actual_sales' => $actual_sales,
                'forecast_sales' => $forecast_sales,
                'is_prediction' => !$item['is_actual_data'], // Untuk membedakan apakah data tsb forecast atau actual
                'mape' => ($item['is_actual_data']) ? self::calculateMAPE($actual_sales, $forecast_sales, $index, $periode) : null,
            ]);
        });

        //Perhitungan MAPE
        $filteredMAPE = $forecast->toBase()
            ->reject(function ($item) {
                return $item['forecast_sales'] == 0 || $item['mape'] == null;
            })
            ->map(function ($item) {
                return $item['mape'];
            })
            ->values() // returning value only without collection keys.
            ->toArray();

        //menghitung rata2 nilai MAPE Akhir.
        $finalMAPE = round(array_sum($filteredMAPE) / count($filteredMAPE), 2);
        // menghitung akurasi 
        $finalAccuracy = 100 -  $finalMAPE; 

        return response()->json([
            'produk' => Produk::where('id_produk', $id_produk)->first(),
            'mape' => $finalMAPE,
            'accuracy' => $finalAccuracy,
            // Dokumentasi Filter Collection: https://laravel.com/docs/10.x/collections#method-filter
            'forecast' => $forecast->filter(fn($item) => !$item['is_prediction'])->values(),
            'prediction' => $forecast->filter(fn($item) => $item['is_prediction'])->values(),
            'chart_data' => $this->renderChartData($forecast),
        ]);
    }
}
