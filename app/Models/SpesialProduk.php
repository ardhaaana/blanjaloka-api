<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpesialProduk extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = 'id';
    public $table = 'spesial_produk';

    protected $fillable = [
        'id_produk', 'diskon',
    ];
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
    protected $hidden = [
        'created_at',
        'updated_at', 'id_produk'
    ];
}
=======
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpesialProduk extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = 'id';
    public $table = 'spesial_produk';

    protected $fillable = [
        'id_produk', 'diskon',
    ];
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
    protected $hidden = [
        'created_at',
        'updated_at', 'id_produk'
    ];
}
>>>>>>> 212e37f6685f1237d24af65419234e5f02412f16
