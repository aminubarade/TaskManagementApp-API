<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated = Validator::make($request->all(),[
            'username' => 'required|unique:users|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' =>'required|email',
            'password' => 'required'
        ]);

        if($validated->fails()){
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
            ],422);
        }else{
            $user = new User;
            $user->username = $request->username;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                "message" => "User saved"
            ],201);
        }

    }


    public function show(User $user)
    {
        //
        return $user;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
        if($user->username){
            $user->username = is_null($request->username) ? $user->username : $request->username; 
            $user->firstname = is_null($request->firstname) ? $user->firstname : $request->firstname; 
            $user->lastname = is_null($request->lastname) ? $user->lastname : $request->lastname; 
            $user->email = is_null($request->email) ? $user->email : $request->email; 
            $user->password = is_null($request->password) ? $user->password : $request->password; 
            $user->update();
            return response()->json([
                "message" => "User updated"
            ],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
