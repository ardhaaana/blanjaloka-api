<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewProduk extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    public $table = 'review_produk';

     protected $fillable = [
        'id_produk','id_customer','review', 'star',
    ];

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk');
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

     protected $hidden = [
        'created_at', 'updated_at'
    ];
}
