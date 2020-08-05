<?php

namespace App\Admin\Http\Controller;

use App\Core\Http\Controllers\Controller;
use App\Admin\Resource\ResourceManager;
use App\Admin\Resource\Page;

class Test extends Controller
{

    public function __invoke()
    {
        dd(ResourceManager::resources());
    }

}
