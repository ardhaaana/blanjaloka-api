<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model
{
    protected $primaryKey = 'id_pedagang';
    public $table = "pedagang";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_pedagang', 'nomor_telepon', 'alamat_pedagang', 'tanggal_lahir', 'nomor_ktp', 'foto_rekening', 'id_pendaftaran',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
   
}
