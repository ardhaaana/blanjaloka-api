<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $primaryKey = 'id';
    public $table = "transaksi";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_transaksi', 'jenis_pembayaran', 'pajak', 'id_customer', 'id_pedagang', 'total_pembayaran',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}