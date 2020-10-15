<?php

use Illuminate\Support\Facades\Route;
use App\Admin\Resource\Resource;

Route::prefix('admin')->middleware('auth:admin')->group(function () {
        Route::get('', \App\Admin\Http\Controller\Admin\IndexController::class)->name('admin.index');
        Resource::each()->routeRegister();
});

Route::prefix('admin')->group(function () {
    Route::match(['get', 'post'], 'login', \App\Admin\Http\Controller\Admin\LoginController::class)->name('admin.login');
    // Resource::each()->routeRegister();
});

