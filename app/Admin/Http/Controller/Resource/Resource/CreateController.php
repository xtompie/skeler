<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class CreateController extends Controller
{

    public function __invoke()
    {

        // resolve resource by request
        $resource = Resource::makeWithRequest(request(), 'create');
        abort_unless($resource, 404);

        // acl
        $resource->acl();

        // init
        $resource = $resource->resourceNew(request()->all());

        // value
        $value = request()->isMethod('post') ? request()->all() : $resource->withDummy();

        // store
        $errors = [];
        if (request()->isMethod('post')) {
            $errors = $resource->store($value);
            if (!$errors) {
                return $resource->redirect();
            }
        }

        // vm
        $vm = [
            'value' => $value,
            'errors' => $errors,
            'resource' => $resource->vm($value, $errors),
        ];

        return view('admin.resource.resource.create', $vm);
    }

}
