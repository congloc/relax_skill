<?php

namespace Modules\Skill\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Skill\Models\Skill;
use Illuminate\Http\JsonResponse as HttpJsonResponse;

class SkillController extends Controller
{
    /***
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $skill = Skill::all();
        
        return response()->json($skill, HttpJsonResponse::HTTP_OK);
    }
}
