<?php

use Illuminate\Support\Facades\Route;
use App\Media\Http\Controllers\ImgFilterController;

Route::get('storage-img/{path}',  ImgFilterController::class)->where('path', '.+');
