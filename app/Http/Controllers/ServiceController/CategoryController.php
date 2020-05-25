<?php

namespace App\Http\Controllers;

use App\Models\Service\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categories;

    public function __construct(Category $category)
    {
        $this->categories = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->categories->all());
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
            $titleJson = ['title'=>$title];
            $this->categories->create($titleJson);

            $returns =  ['data' => ['message' => 'Categoria cadastrada com sucesso']];
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
        $category = Category::find($id);

        return response()->json($category, 201);
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
            $title = $request->json('title');
            $category = Category::find($id);

            $category->title = $title;
            $category->save();
            $return = ['data' => ['message' => 'Categoria atualizada com sucesso']];

            return response()->json($return, 201);
        }catch (\Exception $e) {
            $return = ['data' => ['message' => $e->getMessage()]];
            return response()->json($return);
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
            $category = Category::find($id);
            $category->delete($category);
            $return = ['data' => ['message' => 'Categoria deletada com sucesso']];
            return response()->json($return, 201);
        }catch (\Exception $e) {
            $return = ['data' => ['message' => 'Existem serviços vínculados a sua categoria, delete o serviço primeiro: '.$e->getMessage()]];
            return response()->json($return, 501);
        }
    }
}
