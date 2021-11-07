<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'kode_resep';
    public $table = 'resep_makanan';

     protected $fillable = [
        'judul_resep','waktu', 'resep', 'langkah'
    ];
}