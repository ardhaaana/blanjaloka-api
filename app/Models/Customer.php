<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'id_customer';
    public $table = "customer";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_customer','nomor_telepon','alamat_customer','tanggal_lahir',
        'email_customer', 'username','password', 'jenis_kelamin','token',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'token', 'id_role',  'created_at', 'updated_at'
    ];

     public function role(){
        return $this->belongsTo(Role::class);
    }
    
    public function favoritproduk(){
        return $this->hasMany(FavoritProduk::class, 'id');
    }
    
    public function review(){
        return $this->hasOne(ReviewProduk::class);
    }

}
