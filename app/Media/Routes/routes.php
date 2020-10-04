<?php

use Illuminate\Support\Facades\Route;
use App\Media\Http\Controllers\ModifyController;

Route::prefix('storage')->group(function () {
    Route::get('cache/img/{path}',  ModifyController::class)->where('path', '.+');
});
