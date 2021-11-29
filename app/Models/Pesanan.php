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
        'nama_customer','nomor_telepon','alamat_customer', 'id_produk', 'id_pedagang', 'id_transaksi', 'pilihan_penawaran', 'id_driver',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
    public function pedagang()
    {
        return $this->belongsTo(Pedagang::class, 'id_pedagang');
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'id_driver');
    }
   
}
