<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Database\Seeder;

class FixDataPenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Start updating data!');
        $this->command->getOutput()->progressStart(Penjualan::select('id')->count());
        Penjualan::latest('id_penjualan')->get()->each(function ($item) {
            $jumlahItem = PenjualanDetail::where('id_penjualan', $item->id_penjualan)
                ->sum('jumlah');

            $data = [
                'total_item' => $jumlahItem
            ];

            if ($item->id_member) {
                $diskon = Setting::first()->diskon ?? 0;
                $data['diskon'] = $diskon;

                $potongan = ($item->total_harga * $diskon)/100;
                $bayar = $item->total_harga - $potongan;

                $data['bayar'] = $bayar;
                $data['diterima'] = $bayar;
            }

            $item->update($data);
            $this->command->getOutput()->progressAdvance();
        });
        $this->command->getOutput()->progressFinish();
        $this->command->info('update data finish!');
    }
}
