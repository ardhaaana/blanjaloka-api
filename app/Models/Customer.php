<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

//this is new
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject 
{
    use Authenticatable, Authorizable;

    protected $primaryKey = 'id_customer';
    public $table = "customer";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_customer','nomor_telepon','alamat_customer','tanggal_lahir',
<<<<<<< HEAD
        'email_customer', 'username','password', 'jenis_kelamin', 'token'
=======
        'email_customer', 'username','password', 'jenis_kelamin','token',
>>>>>>> 5c62385410c10963254565518959848154714eda
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
<<<<<<< HEAD
        'password', 'id_role',  'created_at', 'updated_at'
=======
        'password', 'token', 'id_role',  'created_at', 'updated_at'
>>>>>>> 5c62385410c10963254565518959848154714eda
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

<<<<<<< HEAD
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

=======
>>>>>>> 5c62385410c10963254565518959848154714eda
}
