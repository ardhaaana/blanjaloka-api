<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    public $table = 'produk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_produk','satuan','harga_jual','stok_saat_ini','status_produk','id_pedagang',
    ];
}

 
 
 
 
 