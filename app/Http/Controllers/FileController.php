<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\User;

class FileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $path = public_path("storage/app/$user->photo");

//        return response()->download($path);
        return response($path);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();

        $data['photo'] = $user->photo;
        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $image = $request->file('uploaded_file');
            if ($user->photo)
                $name = $user->photo;
            else
            $name = $user->id.Str::kebab($user->name);

            $extenstion = $request->photo->extension();
            $nameFIle = "{$name}.{$extenstion}";

            $upload = $request->photo->storeAs('/images/profile', $nameFIle);
            User::all()->find($user->id)->update(['photo'=>$upload]);

            if ($upload) {
                return response()->json('sucess');
            }else {
                return response()->json('error');
            }
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
