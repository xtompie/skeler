<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;


class UpdateController extends Controller
{

    public function __invoke($id)
    {
        // resolve resource by request
        $resource = Resource::makeWithRequest(request(), 'update');
        abort_unless($resource, 404);

        // acl
        $resource->acl();

        // fetch
        $resource = $resource->withId($id);
        abort_unless($resource, 404);

        // value,
        $resource = request()->isMethod('post') ? $resource->withRequestValue(request()->all()) : $resource;

        // store
        if (request()->isMethod('post')) {
            $resource = $resource->store();
            if (!$resource->erros()) {
                $resource->redirect();
                return;
            }
        }

        // vm
        $vm = [
            'resource' => $resource->vm(),
        ];

        return view('admin.resource.resource.update', $vm);
    }

}
