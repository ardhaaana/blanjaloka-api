<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_role';
    public $table = 'role';

     protected $fillable = [
        'status_user'
    ];

     public function customer(){
        return $this->hasOne(Customer::class);
    }

     public function pengelola(){
        return $this->hasOne(PengelolaPasar::class);
    }

     public function pedagang(){
        return $this->hasOne(Pedagang::class);
    }
}