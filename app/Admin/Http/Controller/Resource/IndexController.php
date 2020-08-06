<?php

namespace App\Admin\Http\Controller\Resource;

use App\Admin\Resource\ResourceManager;
use App\Core\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        $resource = $this->resource();

        dd($resource);

    }

    protected function resource()
    {
        return ResourceManager::resource(request()->route()->getAction()['resource']);
    }

}
