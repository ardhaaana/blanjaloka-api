<<<<<<< HEAD
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
=======
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
>>>>>>> 4b79e20ff8e7744e725297c32b70812bdcafab82
