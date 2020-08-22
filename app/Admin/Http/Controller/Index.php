<?php

namespace App\Admin\Http\Controller;

use App\Core\Http\Controllers\Controller;

class Index extends Controller
{
    public function __invoke()
    {
        return view('admin.index');
    }
}
