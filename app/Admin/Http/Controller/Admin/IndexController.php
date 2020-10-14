<?php

namespace App\Admin\Http\Controller\Admin;

use App\Core\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('admin.admin.index');
    }
}
