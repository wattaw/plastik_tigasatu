<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $table = 'pembelian_detail';
    protected $primaryKey = 'id_pembelian_detail';
    protected $guarded = [];

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk');
        // return $this->belongsTo(Produk::class, 'id_produk');
    }

    // public function pembelian()
    // {
    //     return $this->belongsTo(Pembelian::class, 'pembelian_id');
    // }
    // public function kategori()
    // {
    //     return $this->belongsTo(Kategori::class, 'id_kategori');
    // }
}
