<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_toko';
    public $table = 'toko';

     protected $fillable = [
        'nama_toko', 'alamat_toko', 'id_pedagang',
    ];
}