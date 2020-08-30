<?php

namespace App\Admin\Http\Controller\Resource;

use App\Admin\Resource\Resource;
use App\Core\Http\Controllers\Controller;

class UpdateController extends Controller
{

    public function __invoke()
    {
        $resource = Resource::resourceByRequest(request());
        abort_unless($resource, 404);

        dd(__METHOD__);
    }

}
