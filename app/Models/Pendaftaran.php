<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $primaryKey = 'id_pendaftaran';
    public $table = "pendaftaran";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'alamat', 'nomor_telepon', 'tanggal_lahir', 'nomor_ktp', 'foto_ktp',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
   
}
