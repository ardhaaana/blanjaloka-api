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


$router->post('/register', 'AuthCustomerController@register');
$router->post('/login', 'AuthCustomerController@login');

$router->put('/profile/{id_customer}', 'AuthCustomerController@update');
$router->get('/profile', 'AuthCustomerController@index');

// 'middleware' => 'auth'

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('/produk/search', ['uses' => 'ProdukController@search']);
    $router->get('produk', ['uses' => 'ProdukController@index']);
    $router->post('produk', ['uses' => 'ProdukController@create']);

    $router->get('produk/{id_produk}', ['uses' => 'ProdukController@show']);
    $router->put('produk/{id_produk}', ['uses' =>  'ProdukController@update']);

    $router->delete('produk/{id_produk}', ['uses' => 'ProdukController@destroy']);

    $router->post('jamoperasional', ['uses' => 'JamOperasionalPasarController@create']);
    $router->get('jamoperasional', ['uses' =>  'JamOperasionalPasarController@index']);

    $router->get('jamoperasional/{id_toko}', ['uses' =>  'JamoperasionalpasarController@show']);
    $router->put('jamoperasional/{id_toko}', ['uses' =>  'JamoperasionalpasarController@update']);
    $router->delete('jamoperasional/{id_toko}', ['uses' =>  'JamoperasionalpasarController@destroy']);

    $router->post('pendaftaran', ['uses' => 'PendaftaranController@create']);
    $router->get('pendaftaran', ['uses' =>  'PendaftaranController@index']);

    $router->get('pendaftaran/{id_pendaftaran}', ['uses' =>  'PendaftaranController@show']);
    $router->put('pendaftaran/{id_pendaftaran}', ['uses' =>  'PendaftaranController@update']);
    $router->delete('pendaftaran/{id_pendaftaran}', ['uses' =>  'PendaftaranController@destroy']);


    $router->post('role', ['uses' => 'RoleController@create']);
    $router->get('role', ['uses' =>  'RoleController@index']);

    $router->get('role/{id_role}', ['uses' =>  'RoleController@show']);
    $router->put('role/{id_role}', ['uses' =>  'RoleController@update']);
    $router->delete('role/{id_role}', ['uses' =>  'RoleController@destroy']);


    $router->post('pedagang', ['uses' => 'PedagangController@create']);
    $router->get('pedagang', ['uses' =>  'PedagangController@index']);

    $router->get('pedagang/{id_pedagang}', ['uses' =>  'PedagangController@show']);
    $router->put('pedagang/{id_pedagang}', ['uses' =>  'PedagangController@update']);
    $router->delete('pedagang/{id_pedagang}', ['uses' =>  'PedagangController@destroy']);


    $router->post('tawar_menawar', ['uses' => 'TawarMenawarController@create']);
    $router->get('tawar_menawar', ['uses' =>  'TawarMenawarController@index']);

    $router->get('tawar_menawar/{id_tawar}', ['uses' =>  'TawarMenawarController@show']);
    $router->put('tawar_menawar/{id_tawar}', ['uses' =>  'TawarMenawarController@update']);
    $router->delete('tawar_menawar/{id_tawar}', ['uses' =>  'TawarMenawarController@destroy']);
    
    $router->post('resep', ['uses' => 'ResepController@create']);
    $router->get('resep', ['uses' =>  'ResepController@index']);
    $router->get('resep/search', ['uses' =>  'ResepController@search']);

    $router->get('resep/{kode_resep}', ['uses' =>  'ResepController@show']);
    $router->put('resep/{kode_resep}', ['uses' =>  'ResepController@update']);
    $router->delete('resep/{kode_resep}', ['uses' =>  'ResepController@destroy']);

    $router->post('kategori', ['uses' => 'KategoriProdukController@create']);
    $router->get('kategori', ['uses' =>  'KategoriProdukController@index']);

    $router->get('kategori/search', ['uses' => 'KategoriProdukController@search']);
    $router->get('kategori/{id_kategori}', ['uses' =>  'KategoriProdukController@show']);
    $router->put('kategori/{id_kategori}', ['uses' =>  'KategoriProdukController@update']);
    $router->delete('kategori/{id_kategori}', ['uses' =>  'KategoriProdukController@destroy']);

    
    $router->post('toko', ['uses' => 'TokoController@create']);
    $router->get('toko', ['uses' =>  'TokoController@index']);

    $router->get('toko/search', ['uses' => 'TokoController@search']);
    $router->get('toko/{id_toko}', ['uses' =>  'TokoController@show']);
    $router->put('toko/{id_toko}', ['uses' =>  'TokoController@update']);
    $router->delete('toko/{id_toko}', ['uses' =>  'TokoController@destroy']);


    
    $router->post('pesanan', ['uses' => 'PesananController@create']);
    $router->get('pesanan', ['uses' =>  'PesananController@index']);

    $router->get('pesanan/search', ['uses' => 'PesananController@search']);
    $router->get('pesanan/{id_pesanan}', ['uses' =>  'PesananController@show']);
    $router->put('pesanan/{id_pesanan}', ['uses' =>  'PesananController@update']);
    $router->delete('pesanan/{id_pesanan}', ['uses' =>  'PesananController@destroy']);
    
    $router->post('review', ['uses' => 'ReviewProdukController@create']);
    $router->get('review', ['uses' =>  'ReviewProdukController@index']);

    $router->get('review/{id}', ['uses' =>  'ReviewProdukController@show']);
    $router->put('review/{id}', ['uses' =>  'ReviewProdukController@update']);
    $router->delete('review/{id}', ['uses' =>  'ReviewProdukController@destroy']);

    
    
    $router->post('voucher', ['uses' => 'VoucherController@create']);
    $router->get('voucher', ['uses' =>  'VoucherController@index']);
    
    $router->get('voucher/search', ['uses' => 'VoucherController@search']);

    $router->get('voucher/{id}', ['uses' =>  'VoucherController@show']);
    $router->put('voucher/{id}', ['uses' =>  'VoucherController@update']);
    $router->delete('voucher/{id}', ['uses' =>  'VoucherController@destroy']);
});
