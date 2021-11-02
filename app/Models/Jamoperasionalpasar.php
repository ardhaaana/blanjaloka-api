<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jamoperasionalpasar extends Model
{
    
    protected $primaryKey = 'id_toko';
    public $table = "jam_operasional_pasar";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hari_operasional', 'jam_operasional', 'id_pengelola',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
 
}
