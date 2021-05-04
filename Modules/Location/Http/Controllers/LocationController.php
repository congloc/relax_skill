<?php

namespace Modules\Location\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\JsonResponse as HttpJsonResponse;

use Modules\Location\Repositories\ProvinceRepository;
use Modules\Location\Repositories\WardRepository;

class LocationController extends Controller
{
    /**
     * The attributes that are province repository, ward repository.
     *
     * @var ProvinceRepository
     * @var WardRepository
     */
    protected $provinceRepo,$wardRepo;

    /**
     * Create a new controller instance.
     *
     * @param  ProvinceRepository  $provinceRepo
     * @return void
     */
    public function __construct(ProvinceRepository  $provinceRepo,WardRepository  $wardRepo)
    {
        $this->provinceRepo = $provinceRepo;
        $this->wardRepo = $wardRepo;
    }

    /**
     * Display a listing of the province.
     * @return \Illuminate\Http\Response
     */
    public function getProvince()
    {
        $provinceRepo = $this->provinceRepo->getData();
        return response()->json($provinceRepo, HttpJsonResponse::HTTP_OK);
    }

    /**
     * Display a listing of the ward.
     * @return \Illuminate\Http\Response
     */
    public function getWard()
    {
        $wardRepo = $this->wardRepo->getData();
        return response()->json($wardRepo, HttpJsonResponse::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('location::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('location::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('location::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('location::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
