<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_driver';
    public $table = 'driver';

    protected $fillable = [
        'nama_driver', 'nomor_telepon', 'alamat_driver', 'tanggal_lahir', 
        'nomor_ktp', 'kendaraan', 'foto_stnk', 'id_pendaftaran'
    ];
}
