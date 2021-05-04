<?php

namespace Modules\Rate\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
git
class RateController extends Controller
{
    public function index()
    {
        $rate = Rate::all();
        
        return response()->json($rate, HttpJsonResponse::HTTP_OK);
    }
}
