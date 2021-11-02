<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamOperasionalPasar extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_toko';
    public $table = 'jam_operasional_pasar';

    protected $fillable = [
        'hari_operasional', 'jam_operasional', 'id_pengelola',
    ];
}
