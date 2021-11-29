<?php
/**
 * Created by PhpStorm.
 * User: Spectre
 * Date: 2017/6/19
 * Time: 11:40
 */
return [
         'driver' => env('SESSION_DRIVER','file'),//The file driver is used by default, you can configure it in .env
         'lifetime' => 120,//Cache expiration time
    'expire_on_close' => false,
    'encrypt' => false,
         'files' => storage_path('framework/session'),//file cache save path
    'connection' => null,
    'table' => 'sessions',
    'lottery' => [2, 100],
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => null,
    'secure' => false,
];