<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function registerUser(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'username' => 'required|unique:users|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' =>'required|email',
            'phone' =>'required|unique:users|max:10',
            'password' => 'required'
        ]);

        if($validated->fails()){
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
            ],422);
        }
        $user = new User;
        $user->username = $request->username;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->address = $request->address;
        $user->save();
        $accessToken = $user->createToken('authToken')->accessToken;
        return response()->json([
            "message" => "User Registered successfully",
            "user" => $user,
            "token" => $accessToken,
        ],201);

    }

    public function login(Request $request)
    {
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $user_token['token'] =  $user->createToken('token')->accessToken; 
            return response()->json([
                'success' => true,
                'token' => $user_token,
                'message'=> "Login Successful",
                'user' => $user
            
                
            ], 200); 
        } 
        else{ 
            return response()->json([
                'error' => 'Unauthorised'
            ], 401); 
        } 
    }

    public function logout()
    {
        if(Auth::user()) {
            $request->user()->token()->revoke();
            return response()->json([
                'success' => true,
                'message' => 'Logged out',
            ], 200);
        }
    }
}
