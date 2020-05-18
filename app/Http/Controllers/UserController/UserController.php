<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Validator;
//Passar o validator para a model

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

//        $validator = $this->userValidator($request);
        $data = $request->all();

        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $groups = $data['groups_id'];

        $user = new User();

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $nameFIle = Str::kebab($name).Str::kebab(date('Y-m-d H:i'));
            $namePhotoFormat = preg_replace('/[^a-zA-Z0-9_]/', '', $nameFIle);
            $extPhoto = $request->photo->extension();
            $nameFIleAndExt = "{$namePhotoFormat}.{$extPhoto}";

            $occurrenceOfUsers = DB::select('SELECT COUNT(users.id) FROM users WHERE users.email = :email', ['email' => $email]);

            if (json_encode($occurrenceOfUsers[0])[19] === '0'){
                $upload = $request->photo->storeAs('/images/profile', $nameFIleAndExt);
                $user->fill(['name'  => $name, 'email' => $email, 'password' => Hash::make($password), 'photo' => $upload]);
            }
        }else {
            $user->fill(['name'  => $name, 'email' => $email, 'password' => Hash::make($password)]);
        }

//        if($validator->fails() ) {
//            return response()->json([
//                'message' => 'Validation Failed',
//                'errors' => $validator->errors()
//            ], 422);
//        }
        $user->save();
        $user->groups()->attach($groups);

        $created = DB::table('users')
            ->join('users_groups', 'users.id', '=', 'users_groups.user_id')
            ->join('groups', 'groups.id', '=', 'users_groups.group_id')
            ->select('users.*', 'groups.name as group')
            ->where('users.id', '=', $user->id)
            ->get();

        return response()->json($created[0], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::all()->find($id);

        return response()->json($user) ;
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        dd($data);
        $newMobile = $data['mobile'];
        $newCity = $data['city'];
        $newUf = $data['uf'];
        $newDistrict = $data['district'];

        $data['photo'] = $user->photo;
        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            if ($user->photo)
                $name = $user->photo;
            else
                $name = $user->id.Str::kebab($user->name);

            $name = preg_replace('/[^a-zA-Z0-9_]/', '', $name);
            $extenstion = $request->photo->extension();
            $nameFIle = "{$name}.{$extenstion}";

            $upload = $request->photo->storeAs('/images/profile', $nameFIle);

            DB::table('users')
                ->where('id', $user->id)
                ->update(['mobile' => $newMobile], ['city' => $newCity], ['uf' => $newUf], ['district' => $newDistrict], ['photo' => $upload]);
            if ($upload) {
                return response()->json('sucess');
            }else {
                return response()->json('error');
            }
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
        //
    }

    public function userAuth() {

    }

//    protected function userValidator($request) {
//        $validator = Validator::make($request->all(), [
//            'name' => 'required|max:100',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|max:100',
//        ]);
//        return $validator;
//    }
}
