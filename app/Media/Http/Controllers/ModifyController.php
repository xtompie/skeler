<?php

namespace App\Media\Http\Controllers;

use App\Media\Modify\UrlService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ModifyController extends Controller
{

    public function __invoke(Request $request)
    {
        $out = (new UrlService)->__invoke($request->path());
        abort_unless($out !== null, 404);
        return response()->file($out);
   }

}
