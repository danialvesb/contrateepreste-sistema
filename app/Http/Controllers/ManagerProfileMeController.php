<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class ManagerProfileMeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $dataRec = $request->all();
        $user = auth()->user();
        $newMobile = $dataRec['mobile'];
        $newCity = $dataRec['city'];
        $newUf = $dataRec['uf'];
        $newDistrict = $dataRec['district'];

        $data['photo'] = $user->image;
        if($request->hasFile('photo') && $request->file('photo')->isValid()){

            if ($user->photo) {
                $name = $user->photo;
            }else {
                $name = $user->id.Str::kebab($user->name);
                $name = preg_replace('/[^a-zA-Z0-9_]/', '', $name);
                $extenstion = $request->photo->extension();
                $name = $name.".".$extenstion;
            }

            $upload = $request->photo->storeAs('/images/profile', $name);

            if ($upload) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['photo' => $name, 'mobile' => $newMobile, 'city' => $newCity, 'uf' => $newUf, 'district' => $newDistrict]);
            }

        }
        DB::table('users')
            ->where('id', $user->id)
            ->update(['mobile' => $newMobile, 'city' => $newCity, 'uf' => $newUf, 'district' => $newDistrict]);


        return response()->json(User::all()->find($user->id));
    }

    public function getImgProfile($fileName) {
        $base_path = '\images\profile\\';
        $path = storage_path('app\public'.$base_path.$fileName);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = \Illuminate\Support\Facades\Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
