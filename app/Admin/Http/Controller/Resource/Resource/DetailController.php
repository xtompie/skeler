<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class DetailController extends Controller
{

    public function __invoke($id)
    {
        // resolve resource by request
        $resource = Resource::make(request()->route()->getAction()['resource']);
        abort_unless($resource, 404);

        // init context
        $resource = $resource->withContext(request()->route()->getAction()['context']);
        abort_unless($resource, 404);
        abort_unless($resource->context() === 'detail', 404);

        // acl
        $resource->acl();

        // fetch
        $resource = $resource->resourceById($id);
        abort_unless($resource, 404);

        // vm
        $vm = [
            'name' => $resource->name(),
            'context' => $resource->context(),
            'view' => 'admin.resource.resource.detail',
            'id' => $resource->id(),
            'title' => $resource->title(),
            'vm' => $resource->vm($resource->value()),
        ];

        return view($vm['view'], $vm);
    }

}
