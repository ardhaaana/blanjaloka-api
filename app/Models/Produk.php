<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = 'id_produk';
    public $table = 'produk';

     protected $fillable = [
        'nama_produk','satuan','harga_jual','stok_saat_ini','deskripsi','foto_produk','status_produk', 'id_pedagang'
    ];

    public function review(){
        return $this->hasOne(ReviewProduk::class);
    }
    public function kategori(){
        return $this->hasOne(KategoriProduk::class);
    }
     public function spesialproduk()
    {
        return $this->hasOne(SpesialProduk::class);
    }
    protected $hidden = [
        'id_pedagang'
    ];


}