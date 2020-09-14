<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class UpdateController extends Controller
{

    public function __invoke($id)
    {
        $resource = Resource::makeWithBackground(request(), 'update');
        abort_unless($resource, 404);

        $resource->acl();

        $resource = $resource->withId($id);
        abort_unless($resource, 404);

        $resource = request()->isMethod('post') ? $resource->withRequestValue() : $resource;

        if (request()->isMethod('post')) {
            $resource = $resource->store();
            if (!$resource->errors()) {
                return $resource->redirect();
            }
        }

        return view('admin.resource.resource.update', [
            'resource' => $resource->vm(),
        ]);
    }

}
