<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'admin',
        // 'namespace' => 'App\\Admin\\Http\\Controllers',
    ],
    function () {

        Route::get('test', App\Admin\Http\Controller\Test::class);

    }
);
