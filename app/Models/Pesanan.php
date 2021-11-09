<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $primaryKey = 'id_pesanan';
    public $table = "pesanan";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_customer','nomor_telepon','alamat_customer', 'kode_produk', 'id_pedagang', 'kode_transaksi', 'pilihan_penawaran', 'id_driver',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
   
}
