<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * @var Service
     */
    private $services;

    public function __construct(Service $service)
    {
        $this->services = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->services->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $title = $request->json('title');
            $category = $request->json('category');
            $description =  $request->json('description');
            $file = $request->json('file');


            $serviceJson = ['title'=>$title,
                'category_id'=>$category,
                'description'=>$description,
                'file'=>$file];

            $this->services->create($serviceJson);

            $returns =  ['data' => ['message' => 'Serviço Cadastrado Com Sucesso']];
            return response()->json($returns, 201);

        }catch(\Exception $e) {
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->services->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $service = $this->services->all()->find($id);
            $service->update($request->all());

            $return = ['data' => ['message' => 'Serviço Atualizado Com Sucesso']];

            return response()->json($return, 201);
        }catch (\Exception $e) {
            response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $service = $this->services->all()->find($id);
            $service->delete($service);

            $return = ['data' => ['message' => 'Serviço Deletado Com Sucesso']];

            return response()->json($return);
        }catch (\Exception $e) {
            response()->json($e->getMessage());
        }

    }
}
