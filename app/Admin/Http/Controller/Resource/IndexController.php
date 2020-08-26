<?php

namespace App\Admin\Http\Controller\Resource;

use App\Admin\Resource\ResourceManager;
use App\Core\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function __invoke()
    {
        $resource = ResourceManager::resourceByRequest(request());
        abort_unless($resource, 404);
        $resource->aclForIndex();
        return view($resource->viewForIndex(), [
            'data' => $resource->resourcesForIndex()->map(function($i) {
                return $i->viewDataForIndex();
            }),
        ]);

    }

}
