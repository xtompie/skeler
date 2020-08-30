<?php

namespace App\Admin\Http\Controller\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class DetailController extends Controller
{

    public function __invoke()
    {
        $resource = Resource::resourceByRequest(request());
        abort_unless($resource, 404);

        $resource->aclForDetail();

        $resource = $resource->resourceForDetail();
        abort_unless($resource, 404);


        $vm = [
            'context' => 'detail',
            'view' => $resource->viewForDetail(),
            'resources' => $resource->vmForDetail(),
        ];
        dump($vm);
        dd(__METHOD__);

        return view($vm['view'], $vm);
    }

}
