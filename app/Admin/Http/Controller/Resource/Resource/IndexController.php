<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function __invoke()
    {
        $resource = Resource::makeWithBackground(request(), 'index');
        abort_unless($resource, 404);

        $resource->acl();

        $index = $resource->resourcesByParams();

        $vm = [
            'resource' => $resource->vm(),
            'pagination' => $index['models'],
            'resources' => $index['resources']->map(function(Resource $resource) {
                return $resource->vm();
            }),
        ];

        return view('admin.resource.resource.index', $vm);
    }

}
