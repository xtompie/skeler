<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class DetailController extends Controller
{

    public function __invoke($id)
    {
        // resolve resource by request
        $resource = Resource::makeWithRequest(request(), 'detail');
        abort_unless($resource, 404);

        // acl
        $resource->acl();

        // fetch
        $resource = $resource->resourceById($id);
        abort_unless($resource, 404);

        // vm
        $vm = [
            'resource' => $resource->vm(),
        ];

        return view('admin.resource.resource.detail', $vm);
    }

}
