<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TawarMenawar extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_tawar';
    public $table = 'tawar_menawar';

    protected $fillable = [
        'id_pedagang', 'id_customer', 'harga_nego'
    ];
}
