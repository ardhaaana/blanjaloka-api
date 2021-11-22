<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoritProduk extends Model
{
    
    public $table = "favorit_produk";
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id_produk','id_customer'
    ];
    
     protected $hidden = ["created_at", "updated_at"];

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk');
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

}
