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
        'nama_customer','review', 'star',
    ];

   
}