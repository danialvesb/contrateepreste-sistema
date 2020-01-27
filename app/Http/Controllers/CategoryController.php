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

            $returns =  ['data' => ['message' => 'Categoria Cadastrado Com Sucesso']];
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
