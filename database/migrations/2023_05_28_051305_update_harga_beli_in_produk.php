<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHargaBeliInProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->integer('harga_beli')->nullable()->change();
        });

        Schema::table('pembelian_detail', function (Blueprint $table) {
            $table->integer('harga_beli')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->integer('harga_beli')->change();
        });

        Schema::table('pembelian_detail', function (Blueprint $table) {
            $table->integer('harga_beli')->change();
        });
    }
}
