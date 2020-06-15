<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Psy\Util\Json;


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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $dataRec = $request->all();
        $user = auth()->user();
        $newMobile = isset($dataRec['mobile']) ? $dataRec['mobile'] : null;
        $newCity = isset($dataRec['city']) ? $dataRec['city'] : null;
        $newUf = isset($dataRec['uf']) ? $dataRec['uf'] : null;
        $newDistrict = isset($dataRec['district']) ? $dataRec['district'] : null;

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
                    ->update(['photo' => $name,
                        'mobile' => isset($newMobile) ? $newMobile : $user->mobile,
                        'city' => isset($newCity) ? $newCity : $user->city,
                        'uf' => isset($newUf) ? $newUf : $user->uf,
                        'district' => isset($newDistrict) ? $newDistrict : $user->district]);
            }

        }
        DB::table('users')
            ->where('id', $user->id)
            ->update(['mobile' => isset($newMobile) ? $newMobile : $user->mobile,
                'city' => isset($newCity) ? $newCity : $user->city,
                'uf' => isset($newUf) ? $newUf : $user->uf,
                'district' => isset($newDistrict) ? $newDistrict : $user->district]);


        $id = auth()->user()->id;

        $me = DB::table('users')
            ->join('users_groups', 'users.id', '=', 'users_groups.user_id')
            ->join('groups', 'groups.id', '=', 'users_groups.group_id')
            ->select('users.*', 'groups.name as group')
            ->where('users.id', '=', $id)
            ->get();
        return response()->json($me[0]);
    }

    public function updatePhotoMobile(Request $request)
    {
        $user = auth()->user();
        $data['photo'] = $user->image;
        $photoBin = base64_decode($request['photo']);
        $size = getImageSizeFromString($photoBin);

        if(isset($request->photo)){
            if ($user->photo) {
                $name = $user->photo;
            }else {
                $name = $user->id.Str::kebab($user->name);
                $name = preg_replace('/[^a-zA-Z0-9_]/', '', $name);
                $extenstion = substr($size['mime'], 6);
                $name = "{$name}.{$extenstion}";
            }
            if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0)
                die('Base64 value is not a valid image');

            $ext = substr($size['mime'], 6);
            if (!in_array($ext, ['png', 'gif', 'jpeg']))
                die('Unsupported image type');

            $dir = public_path().'\\storage\\images\\profile\\';
            $img_file = "{$dir}{$name}";
            $status = file_put_contents($img_file, $photoBin);

            return response(['message'=> $status ? 'Sucess' : 'Error'], 201);
        }
        return response(['status' => 'Erro'], 501);
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
