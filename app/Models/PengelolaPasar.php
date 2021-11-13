<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengelolaPasar extends Model
{
    protected $primaryKey = 'id_pengelola';
    public $table = "pengelola_pasar";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_pengelola', 'alamat_pengelola', 'nomor_telepon', 'email', 'username', 'password',
    ];

      public function role(){
        return $this->belongsTo(Role::class);
    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'token',  'id_role',
    ];
}
