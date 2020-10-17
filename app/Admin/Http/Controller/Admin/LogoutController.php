<?php

namespace App\Admin\Http\Controller\Admin;

use App\Core\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke()
    {
        Auth::guard('admin')->logout();
        return response()->redirectToRoute('admin.login');
    }
}




