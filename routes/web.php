<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->get('/', function () use ($router) {
    return $router->app->version();
});

// $router->get('/key', function() {
//     return \Illuminate\Support\Str::random(32);
// });

// //payment midtrans
// $router->post('/payment', 'PaymentsController@bankTransferCharge');


//Customer
$router->post('/register/customer', 'AuthCustomerController@register');
$router->post('/login-email/customer', 'AuthCustomerController@loginemail');
$router->post('/login-nomor/customer', 'AuthCustomerController@loginnomor');
$router->delete('/delete-customer/{id_customer}', 'AuthCustomerController@destroy');

$router->put('/profile/customer/{id_customer}', 'AuthCustomerController@update');
$router->put('/profile/customer/email/{id_customer}', 'AuthCustomerController@emailupdate');
$router->put('/profile/customer/password/{id_customer}', 'AuthCustomerController@passwordupdate');
$router->put('/profile/customer/telepon/{id_customer}', 'AuthCustomerController@teleponupdate');

$router->get('/profile/customer', 'AuthCustomerController@index');

//pengelola pasar
$router->post('/register/pengelola', 'AuthPengelolaPasarController@register');
$router->post('/login/pengelola', 'AuthPengelolaPasarController@login');

$router->put('/profile/pengelola/{id_pengelola}', 'AuthPengelolaPasarController@update');
$router->get('/profile/pengelola', 'AuthPengelolaPasarController@index');


// 'middleware' => 'auth'



$router->group(['prefix' => 'api/produk'], function () use ($router) {
    $router->post('/', ['uses' => 'ProdukController@create']);
    $router->get('/search', ['uses' => 'ProdukController@search']);
    $router->get('/semua-produk', ['uses' => 'ProdukController@index']);
    $router->get('/{id_produk}', ['uses' => 'ProdukController@show']);
    $router->get('data/review', ['uses' => 'ProdukController@produkreview']);
    $router->get('/{id_produk}/spesial/{id}', ['uses' => 'ProdukController@spesialshow']);
    $router->put('/{id_produk}', ['uses' =>  'ProdukController@update']);
    $router->delete('/delete-produk/{id_produk}', ['uses' => 'ProdukController@destroy']);
});

$router->group(['prefix' => 'api/pedagang'], function () use ($router) {
    $router->post('/', ['uses' => 'PedagangController@create']);
    $router->get('/', ['uses' =>  'PedagangController@index']);
    $router->get('/{id_pedagang}', ['uses' =>  'PedagangController@show']);
    $router->get('data/toko', ['uses' =>  'PedagangController@tokoshow']);
    $router->put('/update-data/{id_pedagang}', ['uses' =>  'PedagangController@update']);
    $router->delete('/delete-pedagang/{id_pedagang}', ['uses' =>  'PedagangController@destroy']);
});

$router->group(['prefix' => 'api/data-toko'], function () use ($router) {
    $router->post('/', ['uses' => 'TokoController@create']);
    $router->get('/', ['uses' =>  'TokoController@index']);

    $router->get('/search', ['uses' => 'TokoController@search']);
    $router->get('list-toko/{id_toko}', ['uses' =>  'TokoController@show']);
    $router->put('update-data/{id_toko}', ['uses' =>  'TokoController@update']);
    $router->delete('delete-toko/{id_toko}', ['uses' =>  'TokoController@destroy']);
});

$router->group(['prefix' => 'api/spesial-produk'], function () use ($router) {
    $router->post('/', ['uses' => 'SpesialProdukController@create']);
    $router->get('/search', ['uses' => 'SpesialProdukController@search']);
    $router->get('/', ['uses' => 'SpesialProdukController@index']);
    $router->get('/{id}', ['uses' => 'SpesialProdukController@show']);
    $router->put('/{id}', ['uses' =>  'SpesialProdukController@update']);
    $router->delete('delete-spesial/{id}', ['uses' => 'SpesialProdukController@destroy']);
});

$router->group(['prefix' => 'api/jam-operasional'], function () use ($router) {
    $router->post('/', ['uses' => 'JamOperasionalPasarController@create']);
    $router->get('/', ['uses' =>  'JamOperasionalPasarController@index']);
    $router->get('/{id_toko}', ['uses' =>  'JamoperasionalpasarController@show']);
    $router->put('/{id_toko}', ['uses' =>  'JamoperasionalpasarController@update']);
    $router->delete('/delete-toko/{id_toko}', ['uses' =>  'JamoperasionalpasarController@destroy']);
});

$router->group(['prefix' => 'api/pendaftaran'], function () use ($router) {
    $router->post('/', ['uses' => 'PendaftaranController@create']);
    $router->get('/', ['uses' =>  'PendaftaranController@index']);
    $router->get('/{id_pendaftaran}', ['uses' =>  'PendaftaranController@show']);
    $router->put('/{id_pendaftaran}', ['uses' =>  'PendaftaranController@update']);
    $router->delete('delete-pendaftaran/{id_pendaftaran}', ['uses' =>  'PendaftaranController@destroy']);
});

$router->group(['prefix' => 'api/role'], function () use ($router) {
    $router->post('/', ['uses' => 'RoleController@create']);
    $router->get('/', ['uses' =>  'RoleController@index']);

    $router->get('/customer/pengelola/pedagang', ['uses' =>  'RoleController@show']);
    $router->put('/{id_role}', ['uses' =>  'RoleController@update']);
    $router->delete('delete-role/{id_role}', ['uses' =>  'RoleController@destroy']);
});

$router->group(['prefix' => 'api/tawar-menawar'], function () use ($router) {
    $router->post('/', ['uses' => 'TawarMenawarController@create']);
    $router->get('/', ['uses' =>  'TawarMenawarController@index']);
    $router->get('{id_tawar}', ['uses' =>  'TawarMenawarController@show']);
    $router->put('{id_tawar}', ['uses' =>  'TawarMenawarController@update']);
    $router->delete('delete-tawar{id_tawar}', ['uses' =>  'TawarMenawarController@destroy']);
});

$router->group(['prefix' => 'api/resep'], function () use ($router) {
    $router->post('/', ['uses' => 'ResepController@create']);
    $router->get('/', ['uses' =>  'ResepController@index']);
    $router->get('/search', ['uses' =>  'ResepController@search']);
    $router->get('/{kode_resep}', ['uses' =>  'ResepController@show']);
    $router->put('/{kode_resep}', ['uses' =>  'ResepController@update']);
    $router->delete('delete-resep/{kode_resep}', ['uses' =>  'ResepController@destroy']);
});

$router->group(['prefix' => 'api/kategori-produk'], function () use ($router) {
    $router->post('/', ['uses' => 'KategoriProdukController@create']);
    $router->get('/', ['uses' =>  'KategoriProdukController@index']);
    $router->get('/search', ['uses' => 'KategoriProdukController@search']);
    $router->get('/{id_kategori}/produk/search', ['uses' => 'KategoriProdukController@produkshow']);
    $router->get('/{id_kategori}', ['uses' =>  'KategoriProdukController@show']);
    $router->put('/{id_kategori}', ['uses' =>  'KategoriProdukController@update']);
    $router->delete('delete-kategori/{id_kategori}', ['uses' =>  'KategoriProdukController@destroy']);
});

$router->group(['prefix' => 'api/pesanan'], function () use ($router) {
    $router->post('/', ['uses' => 'PesananController@create']);
    $router->get('/', ['uses' =>  'PesananController@index']);
    $router->get('/search', ['uses' => 'PesananController@search']);
    $router->get('/{id_pesanan}', ['uses' =>  'PesananController@show']);
    $router->put('/{id_pesanan}', ['uses' =>  'PesananController@update']);
    $router->delete('delete-pesanan/{id_pesanan}', ['uses' =>  'PesananController@destroy']);
});

$router->group(['prefix' => 'api/review'], function () use ($router) {
    $router->post('/', ['uses' => 'ReviewProdukController@create']);
    $router->get('/', ['uses' =>  'ReviewProdukController@index']);

    $router->get('/{id}', 'ReviewController@show_produk');

    $router->get('/{id}', ['uses' =>  'ReviewProdukController@show']);
    $router->put('/{id}', ['uses' =>  'ReviewProdukController@update']);
    $router->delete('delete-review/{id}', ['uses' =>  'ReviewProdukController@destroy']);
});

$router->group(['prefix' => 'api/voucher'], function () use ($router) {
    $router->post('/', ['uses' => 'VoucherController@create']);
    $router->get('/', ['uses' =>  'VoucherController@index']);
    $router->get('/search', ['uses' => 'VoucherController@search']);
    $router->get('/{id}', ['uses' =>  'VoucherController@show']);
    $router->put('/{id}', ['uses' =>  'VoucherController@update']);
    $router->delete('delete-voucher/{id}', ['uses' =>  'VoucherController@destroy']);
});

$router->group(['prefix' => 'api/driver'], function () use ($router) {
    $router->post('/', ['uses' => 'DriverController@create']);
    $router->get('/', ['uses' =>  'DriverController@index']);
    $router->get('/search', ['uses' => 'DriverController@search']);
    $router->get('/{id_driver}', ['uses' =>  'DriverController@show']);
    $router->put('/{id_driver}', ['uses' =>  'DriverController@update']);
    $router->delete('delete-driver/{id_driver}', ['uses' =>  'DriverController@destroy']);
});

$router->group(['prefix' => 'api/favorit'], function () use ($router) {
    $router->post('/', ['uses' => 'FavoritProdukController@create']);
    $router->get('/', ['uses' =>  'FavoritProdukController@index']);
    $router->get('/{id}', ['uses' =>  'FavoritProdukController@show']);
    $router->delete('delete-favorit/{id}', ['uses' =>  'FavoritProdukController@destroy']);
});

$router->group(['prefix' => 'api/keranjang'], function () use ($router) {
    $router->post('/', ['uses' => 'KeranjangProdukController@create']);
    $router->get('/', ['uses' =>  'KeranjangProdukController@index']);
    $router->get('/{id}', ['uses' =>  'KeranjangProdukController@show']);
    $router->put('update-keranjang/{id}', ['uses' =>  'KeranjangProdukController@update']);
    $router->delete('/delete-keranjang/{id}', ['uses' =>  'KeranjangProdukController@destroy']);
});

// $router->post('transaksi', ['uses' => 'TransaksiController@create']);
// $router->get('transaksi', ['uses' =>  'TransaksiController@index']);

// $router->get('transaksi/search', ['uses' => 'TransaksiController@search']);
// $router->get('transaksi/{id}', ['uses' =>  'TransaksiController@show']);
// $router->put('transaksi/{id}', ['uses' =>  'TransaksiController@update']);
// $router->delete('transaksi/{id}', ['uses' =>  'TransaksiController@destroy']);


