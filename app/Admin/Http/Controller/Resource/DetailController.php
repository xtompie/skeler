<?php

namespace App\Admin\Http\Controller\Resource;

use App\Admin\Resource\ResourceManager;
use App\Core\Http\Controllers\Controller;

class DetailController extends Controller
{

    public function __invoke()
    {
        $resource = ResourceManager::resourceByRequest(request());
        abort_unless($resource, 404);
        $resource->aclDetail();
        $detail = $resource->getResourceDetail();
        abort_unless($detail, 404);
        return view($resource->viewDetail(), [
            'data' => $detail->dataDetail(),
        ]);
    }

}
