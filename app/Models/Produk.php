<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $guarded = [];

//     public function pembelianDetails()
// {
//     return $this->hasMany(PembelianDetail::class, 'id_produk');
// }

//     public function kategori()
//     {
//         return $this->hasOne(Kategori::class, 'id_kategori');
//     }

}
