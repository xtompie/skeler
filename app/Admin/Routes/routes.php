<?php

use Illuminate\Support\Facades\Route;
use App\Admin\Resource\Resource;


Route::group(
    [
        'prefix' => 'admin',
    ],
    function () {
        Resource::each()->routeRegister();
    }
);
