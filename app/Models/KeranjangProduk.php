<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangProduk extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_keranjang';
    public $table = 'keranjang';

    protected $fillable = [
        'nama_produk', 'harga_jual', 'jumlah_beli', 'total_harga', 'detail_produk',
    ];
}
