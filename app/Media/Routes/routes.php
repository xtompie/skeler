<?php

use Illuminate\Support\Facades\Route;
use App\Media\Http\Controllers\ModifyController;

Route::get('storage-img/{path}',  ModifyController::class)->where('path', '.+');
