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

$router->post('/register', 'AuthPengelolaPasarController@register');
$router->post('/login', 'AuthPengelolaPasarController@login');


$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {

    $router->get('produk', ['uses' => 'ProdukController@index']);
    $router->post('produk', ['uses' => 'ProdukController@create']);

    $router->get('produk/{kode_produk}', ['uses' => 'ProdukController@show']);
    $router->put('produk/{kode_produk}', ['uses' =>  'ProdukController@update']);

    $router->delete('produk/{kode_produk}', ['uses' => 'ProdukController@destroy']);

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
});
