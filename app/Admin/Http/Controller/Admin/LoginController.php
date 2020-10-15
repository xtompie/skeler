<?php

namespace App\Admin\Http\Controller\Admin;

use App\Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $error = false;

        if ($request->isMethod('post')) {
            if (Auth::attempt($credentials)) {
                return redirect()->intended(route('admin.index'));
            }
            else {
                $error = true;
            }
        }

        return view('admin.admin.login', [
            'error' => $error,
            'email' => optional($credentials)['email'],
            'password' => optional($credentials)['password'],
        ]);
    }
}




