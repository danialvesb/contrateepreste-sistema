<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;

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

        $services = DB::table('services')
            ->select('*')
            ->get();

        return response()->json($services);
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
            $description =  $request->json('description');
            $imagePath = $request->json('image_path');
            $categories = $request->json('categories');

            $serviceData = ['title'=>$title,
                'description'=>$description,
                'image_path'=>$imagePath];

            $service =  $this->services->create($serviceData);
            $service->categories()->attach($categories);

            $returns =  ['data' => ['message' => 'Serviço cadastrado com sucesso']];
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
        $service = Service::find($id);

        foreach ($service->categories as $category) {
//            echo $category->pivot->category_id;
        }

        return response()->json($service, 201);
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
            $return = ['data' => ['message' => 'Não é possível deletar serviços que tem ofertas '.$e->getMessage()]];
            return response()->json($return);
        }

    }
}
