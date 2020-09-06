<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;


class UpdateController extends Controller
{

    public function __invoke($id)
    {
        // resolve resource by request
        $resource = Resource::make(request()->route()->getAction()['resource']);
        abort_unless($resource, 404);

        // init context
        $resource = $resource->withContext(request()->route()->getAction()['context']);
        abort_unless($resource, 404);
        abort_unless($resource->context() === 'update', 404);

        // acl
        $resource->acl();

        // fetch
        $resource = $resource->resourceById($id);
        abort_unless($resource, 404);

        // value,
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
            'view' => 'admin.resource.resource.update',
            'value' => $value,
            'errors' => $errors,
            'resource' => $resource->vm($value, $errors),
        ];

        dump($vm);
        dd(__METHOD__);

        return view($vm['view'], $vm);
    }

}
