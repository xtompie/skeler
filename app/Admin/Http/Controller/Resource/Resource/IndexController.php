<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function __invoke()
    {
        // resolve resource by request
        $resource = Resource::make(request()->route()->getAction()['resource']);
        abort_unless($resource, 404);

        // init context
        $resource = $resource->withContext(request()->route()->getAction()['context']);
        abort_unless($resource, 404);
        abort_unless($resource->context() === 'index', 404);

        // acl
        $resource->acl();

        // fetch
        $index = $resource->resourcesByParams(request()->all());

        // vm
        $vm = [
            'context' => $resource->context(),
            'view' => 'admin.resource.resource.index',
            'labels' => $resource->resolveFields()->map(function($field) {
                return $field->label();
            }),
            'pagination' => $index['models'],
            'resources' => $index['resources']->map(function(Resource $resource) {
                return $resource->vm($resource->value());
            }),
        ];

        return view($vm['view'], $vm);
    }

}
