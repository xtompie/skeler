<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class CreateController extends Controller
{

    public function __invoke()
    {

        $resource = Resource::makeWithRequest(request(), 'create');
        abort_unless($resource, 404);

        $resource->acl();

        $resource = $resource->resourceNew();

        $resource = request()->isMethod('post') ? $resource->withRequestValue() : $resource;

        if (request()->isMethod('post')) {
            $resource = $resource->store();
            if (!$resource->errors()) {
                return $resource->redirect();
            }
        }

        return view('admin.resource.resource.create', [
            'resource' => $resource->vm(),
        ]);
    }

}
