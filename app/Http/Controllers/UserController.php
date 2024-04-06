<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Hash;
use App\Models\User;

class UserController extends Controller
{
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        if($user){
            $user->username = is_null($request->username) ? $user->username : $request->username; 
            $user->firstname = is_null($request->firstname) ? $user->firstname : $request->firstname; 
            $user->lastname = is_null($request->lastname) ? $user->lastname : $request->lastname; 
            $user->phone = is_null($request->phone) ? $user->phone : $request->phone; 
            $user->email = is_null($request->email) ? $user->email : $request->email; 
            $user->password = is_null($request->password) ? $user->password : $request->password; 
            $user->update();
            return response()->json([
                "message" => "User record updated"
            ],201);
        }
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
            return response()->json([
                "message" => "User Deleted"
            ], 200);
        }else {
            return response()->json([
                "message" => "User Not Found"
            ],404);
        }
    }
}
