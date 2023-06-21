<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateDataPenjualanDetailForMovingAverageAlgorithm extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // Generate data for penjualan and penjualan_detai from 2022-01-01 to now;
    public function run()
    {
        // Get all available produk IDs
        $produk_ids = Produk::pluck('id_produk')->toArray();

        // Get all available member IDs
        $member_ids = Member::pluck('id_member')->toArray();

        // Set start date for data generation
        $start_date = Carbon::parse('2020-01-01'); // change this to needed date for data generation;

        // Loop through each day from start date until today
        while ($start_date->lte(now())) {
            // Generate random number of jumlah penjualan per hari
            $penjualan_count = rand(2, 50);

            // Generate penjualan data for the day
            for ($i = 0; $i < $penjualan_count; $i++) {
                // Generate random total item for the penjualan
                $total_item = rand(1, 50);

                // Generate random member ID or null
                $id_member = rand(0, 1) ? null : $member_ids[array_rand($member_ids)];

                // Generate new penjualan
                $penjualan = Penjualan::create([
                    'id_member' => $id_member,
                    'total_item' => $total_item,
                    'total_harga' => 0, // This will be updated later
                    'diskon' => 0,
                    'bayar' => 0, // This will be updated later
                    'diterima' => 0, // This will be updated later
                    'id_user' => 3,
                    'created_at' => $start_date,
                    'updated_at' => $start_date,
                ]);

                // Generate random jumlah barang per transaksi
                $penjualan_detail_count = rand(1, 15);

                // Generate penjualan_detail data for the penjualan
                $subtotal = 0;
                for ($j = 0; $j < $penjualan_detail_count; $j++) {
                    // Get random produk ID and harga_jual
                    $produk = Produk::inRandomOrder()->first(['id_produk', 'harga_jual']);

                    // Generate random jumlah barang pada produk
                    $jumlah = rand(1, 20);

                    // Calculate subtotal for the produk
                    $harga_jual = $produk->harga_jual;
                    $subtotal_produk = $harga_jual * $jumlah;

                    // Generate new penjualan_detail
                    PenjualanDetail::create([
                        'id_penjualan' => $penjualan->id_penjualan,
                        'id_produk' => $produk->id_produk,
                        'harga_jual' => $harga_jual,
                        'jumlah' => $jumlah,
                        'diskon' => 0,
                        'subtotal' => $subtotal_produk,
                        'created_at' => $start_date,
                        'updated_at' => $start_date,
                    ]);

                    // Add subtotal for the produk to the penjualan's total harga and bayar
                    $subtotal += $subtotal_produk;
                    $penjualan->total_harga += $subtotal_produk;
                    $penjualan->bayar += $subtotal_produk;
                    $penjualan->diterima += $subtotal_produk;
                }

                // Save the updated penjualan total harga and bayar
                $penjualan->save();
            }

            // Move to the next day
            $start_date->addDay();
        }
    }
}
