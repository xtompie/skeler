<?php

namespace App\Admin\Http\Controller\Admin;

use App\Core\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function __invoke()
    {
        dd(url()->previous());
        return view('admin.admin.login');
    }
}
