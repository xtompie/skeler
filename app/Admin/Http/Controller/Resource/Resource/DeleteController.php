<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class DeleteController extends Controller
{

    public function __invoke($id)
    {
        $resource = Resource::makeWithRequest(request(), 'delete');
        abort_unless($resource, 404);

        $resource->acl();

        $resource = $resource->resourceById($id);
        abort_unless($resource, 404);

        $resource = request()->isMethod('post') 
                  ? $resource->withRequestValue() 
                  : $resource;

        if (request()->isMethod('post')) {
            $resource = $resource->delete();
            if (!$resource->errors()) {
                return $resource->redirect();
            }
        }

        return view('admin.resource.resource.delete', [
            'resource' => $resource->vm(),
        ]);
    }

}
