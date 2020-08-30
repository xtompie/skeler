<?php

namespace App\Admin\Http\Controller\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function __invoke()
    {
        $resource = Resource::resourceByRequest(request());
        abort_unless($resource, 404);

        $resource->aclForIndex();

        $index = $resource->resourcesForIndex();

        $vm = [
            'context' => 'index',
            'view' => $resource->viewForIndex(),
            'labels' => $resource->fieldsForIndex()->map(function($field) {
                return $field->label();
            }),
            'pagination' => $index['models'],
            'resources' => $index['resources']->map(function($resource) {
                return $resource->vmForIndex();
            }),
        ];
        dump($vm);
        dd(__METHOD__);

        return view($vm['view'], $vm);
    }

}
