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

    public function review()
    {
        return $this->hasOne(ReviewProduk::class);
    }
    public function kategori()
    {
        return $this->hasOne(KategoriProduk::class);
    }
     public function spesialproduk()
    {
        return $this->hasOne(SpesialProduk::class);
    }
     public function favoritproduk(){
        return $this->hasOne(FavoritProduk::class);
    }
    
    public function keranjangproduk(){
        return $this->hasOne(KeranjangProduk::class);
    }

    protected $primaryKey = 'id_produk';
    public $table = 'produk';

     protected $fillable = [
        'nama_produk','satuan','harga_jual','jumlah_produk','deskripsi','foto_produk','status_produk',
        'id_pedagang', 'id_kategori'
    ];

    protected $hidden = [
        'id_pedagang', 'created_at', 'updated_at'
    ];

}
