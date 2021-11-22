<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    public $table = 'voucher';

     protected $fillable = [
        'nama_voucher', 'id_voucher', 'id_customer'
    ];

    protected $hidden =[
        'id_customer'
    ];
}