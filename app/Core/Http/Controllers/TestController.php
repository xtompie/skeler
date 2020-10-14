<?php

namespace App\Core\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{

    public function __invoke()
    {
        dump(Auth::user());
        dump(Auth::id());
        dump(Auth::check());
        return null;
    }

}
