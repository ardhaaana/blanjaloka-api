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
        'id_keranjang', 'id_customer', 'id_produk', 'jumlah_produk'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

}

