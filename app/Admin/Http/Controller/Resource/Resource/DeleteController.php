<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class DeleteController extends Controller
{

    public function __invoke($id)
    {
        // resolve resource by request
        $resource = Resource::makeWithRequest(request(), 'delete');
        abort_unless($resource, 404);

        // acl
        $resource->acl();

        // fetch
        $resource = $resource->resourceById($id);
        abort_unless($resource, 404);

        // delete
        if (request()->isMethod('post')) {
            $resource->delete();
            $resource->redirect();
            return;
        }

        // vm
        $vm = [
            'resource' => $resource->vm(),
        ];

        return view('admin.resource.resource.delete', $vm);
    }

}
