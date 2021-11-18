<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangProduk extends Model
{
    protected $primaryKey = 'id';
    public $table = 'keranjang_produk';
    
    protected $fillable = [
        'id_produk', 'id_customer', 'jumlah_produk', 'subtotal'
    ];
      
    protected $hidden = ["created_at", "updated_at"];


    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

}