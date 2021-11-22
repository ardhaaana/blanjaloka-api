<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_kategori';
    public $table = 'kategori_produk';

     protected $fillable = [
        'jenis_kategori',
    ];

    public function produk(){
        return $this->belongsTo(Produk::class);
    }
     protected $hidden =[
        'id_produk', 'created_at', 'updated_at'
    ];
    
}
