<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Member;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        $kategori = Kategori::count();
        $produk = Produk::count();
        $supplier = Supplier::count();
        $member = Member::count();

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');
        $bulan_awal = date('Y-01-d');
        $bulan_akhir = date ('Y-m-d');

        $data_tanggal = array();
        $data_bulan = array();
        $data_pendapatan = array();

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('nominal');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $data_pendapatan[] += $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        $tanggal_awal = date('Y-m-01');

        // Query untuk mendapatkan produk terlaris setiap bulan
        $produkTerlaris = DB::table('produk')
        ->join('penjualan_detail', 'produk.id_produk', '=', 'penjualan_detail.id_produk')
        ->join('penjualan', 'penjualan.id_penjualan', '=', 'penjualan_detail.id_penjualan')
        ->select('produk.nama_produk', DB::raw('SUM(penjualan_detail.jumlah) as total_terjual'))
        ->whereBetween('penjualan.created_at', [$tanggal_awal, $tanggal_akhir])
        ->groupBy('produk.id_produk', 'produk.nama_produk')
        ->orderByDesc('total_terjual')
        ->limit(10)
        ->get();
    
        if (auth()->user()->level == 1) {
            // return $produkTerlaris;
            return view('admin.dashboard', compact('kategori', 'produk', 'supplier', 'member', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan', 'produkTerlaris'));
        } else {
            return view('kasir.dashboard');
        }
    }
}
