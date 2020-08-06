<?php

use Illuminate\Support\Facades\Route;
use App\Admin\Resource\ResourceManager;


Route::group(
    [
        'prefix' => 'admin',
    ],
    function () {

        ResourceManager::each()->routeRegister();

        Route::get('test', App\Admin\Http\Controller\Test::class);

    }
);
