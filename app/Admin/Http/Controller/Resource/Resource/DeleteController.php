<?php

namespace App\Admin\Http\Controller\Resource\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class DeleteController extends Controller
{

    public function __invoke($id)
    {
        // resolve resource by request
        $resource = Resource::make(request()->route()->getAction()['resource']);
        abort_unless($resource, 404);

        // init context
        $resource = $resource->withContext(request()->route()->getAction()['context']);
        abort_unless($resource, 404);
        abort_unless($resource->context() === 'delete', 404);

        // acl
        $resource->acl();

        // fetch
        $resource = $resource->resourceById($id);
        abort_unless($resource, 404);

        // delete
        if (request()->isMethod('post')) {
            $resource->delete();
            $resource->redirect();
        }

        // vm
        $vm = [
            'name' => $resource->name(),
            'context' => $resource->context(),
            'view' => 'admin.resource.resource.delete',
            'id' => $resource->id(),
            'title' => $resource->title(),
            'vm' => $resource->vm($resource->value()),
        ];

        dump($vm);
        dd(__METHOD__);

        return view($vm['view'], $vm);
    }

}
