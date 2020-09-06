<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class CreateController extends Controller
{

    public function __invoke()
    {
        // resolve resource by request
        $resource = Resource::make(request()->route()->getAction()['resource']);
        abort_unless($resource, 404);

        // init context
        $resource = $resource->withContext(request()->route()->getAction()['context']);
        abort_unless($resource, 404);
        abort_unless($resource->context() === 'create', 404);

        // acl
        $resource->acl();

        // init
        $resource = $resource->resourceNew(request()->all());

        // value
        $value = request()->isMethod('post') ? request()->all() : $resource->value();

        // store
        $errors = [];
        if (request()->isMethod('post')) {
            $errors = $resource->store($value);
            if (!$errors) {
                $resource->redirect();
            }
        }

        // vm
        $vm = [
            'context' => $resource->context(),
            'view' => 'admin.resource.resource.create',
            'value' => $value,
            'errors' => $errors,
            'resource' => $resource->vm($value, $errors),
        ];

        dump($vm);
        dd(__METHOD__);

        return view($vm['view'], $vm);
    }

}
