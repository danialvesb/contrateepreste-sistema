<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
     * @return Response
     */
    public function index()
    {

        $services = DB::table('services')
            ->select('*')
            ->get();

        return response()->json($services);
    }

    public function getImgService($fileName) {
        $base_path = '\images\services\\';
        $path = storage_path('app\public'.$base_path.$fileName);

        if (!File::exists($path)) {
            return response('erro', 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = \Illuminate\Support\Facades\Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $service = new Service();

            $title = $data['title'];
            $description =  $data['description'];
            $categories = $data['category_selected'];
            $image = $data['image'];

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $nameFIle = Str::kebab($title).Str::kebab(date('Y-m-d H:i'));
                $namePhotoFormat = preg_replace('/[^a-zA-Z0-9_]/', '', $nameFIle);
                $extPhoto = $request->image->extension();
                $nameFIleAndExt = "{$namePhotoFormat}.{$extPhoto}";

                $upload = $request->image->storeAs('/images/services', $nameFIleAndExt);

                $service->fill(['title' => $title, 'description' => $description, 'image_path' => $nameFIleAndExt]);
                $service->save();
                $service->categories()->attach($categories);
            }else{
                $service->fill(['title' => $title, 'description' => $description, 'image_path' => 'null']);
                $service->save();
                $service->categories()->attach($categories);
            }


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
     * @return Response
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
     * @param Request $request
     * @param  int  $id
     * @return Response
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
     * @return Response
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
