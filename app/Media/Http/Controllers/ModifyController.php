<?php

namespace App\Media\Http\Controllers;

use App\Media\Modify\UrlProcess;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ModifyController extends Controller
{

    public function __invoke(Request $request)
    {
        $formula = (new UrlProcess)->__invoke($request->path());
        abort_unless($formula, 404);
        dd($formula);
        return response()->file($formula->output());
   }

}
