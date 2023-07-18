<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request)
    {

    }

    public function login(Request $request)
    {
       $request->validate([
            'username' => 'required',
            'password' => 'required', ]);

        $userData = $request->only('username', 'password');
        
        if(!Auth::attempt($userData)){
            $error = "invalid credentials";
            return $error;
        }
        $user = Auth::user();
        return ['user' => $user];
    }
}
