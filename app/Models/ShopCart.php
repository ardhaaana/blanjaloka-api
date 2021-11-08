<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_produk';
    public $table = 'shop_cart';

     protected $fillable = [
        'nama_produk','harga_produk','satuan','status_produk','id_pedagang'
    ];
}