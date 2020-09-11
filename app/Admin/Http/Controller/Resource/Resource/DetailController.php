<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class DetailController extends Controller
{

    public function __invoke($id)
    {
        $resource = Resource::makeWithRequest(request(), 'detail');
        abort_unless($resource, 404);

        $resource->acl();

        $resource = $resource->resourceById($id);
        abort_unless($resource, 404);

        return view('admin.resource.resource.detail', [
            'resource' => $resource->vm(),
        ]);
    }

}
