<?php

use Illuminate\Support\Facades\Route;
use App\Admin\Resource\Resource;


Route::group(
    [
        'prefix' => 'admin',
    ],
    function () {

        Route::get('', App\Admin\Http\Controller\Index::class);

        Resource::each()->routeRegister();

        Route::get('test', App\Admin\Http\Controller\Test::class);

    }
);
