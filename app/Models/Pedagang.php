<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_pedagang';
    public $table = 'pedagang';

    protected $fillable = [
        'nama_pedagang', 'nomor_telepon', 'alamat_pedagang', 'tanggal_lahir', 'nomor_ktp', 'foto_rekening', 'id_pendaftaran'
    ];
}
