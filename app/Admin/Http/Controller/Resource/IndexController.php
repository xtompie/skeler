<?php

namespace App\Admin\Http\Controller\Resource;

use App\Admin\Resource\ResourceManager;
use App\Core\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function __invoke()
    {
        $resource = ResourceManager::resourceByRequest(request());
        abort_unless($resource, 404);
        $resource->aclIndex();
        // return view($resource->viewIndex(), [
        //     'data' => $resource->getResourcesForIndex()->map(function($i) {
        //         return $i->dataIndex();
        //     }),
        // ]);
        dump(app(\Faker\Generator::class)->sentence(6, true));
        dump(app(\Faker\Generator::class)->paragraph(3, true));
        dump(app(\Faker\Generator::class)->text(600));
        dd();
    }

}
