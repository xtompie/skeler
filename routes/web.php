<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

require base_path('app/Admin/Routes/routes.php');
require base_path('app/Media/Routes/routes.php');

Route::get('/', function () {
    return \App\Media\Img\Spawn::invoke('article', 'Moja nazwa xd (asd).JPEG');
});

