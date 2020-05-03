<?php

namespace App\Http\Controllers;

use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $name = $request->json('name');
        $email = $request->json('email');
        $password = $request->json('password');
        $groups = $request->json('groups_id');

        $user = new User();
        $user->fill(['name'  => $name,
            'email' => $email,
            'password' => Hash::make($password)]);

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
