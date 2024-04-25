<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordResetRequest;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
   public function sendPasswordResetRequest(Request $request) 
   {
        $validated = Validator::make($request->all(),[
            'email' =>'required|email',
        ]);
        if($validated->fails()){
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
            ],422);
        }
        $user = User::where('email', $request->email)->first();
        if($user)
        {
            $passwordResetRequest = new PasswordResetRequest;
            $passwordResetRequest->user_id = $user->id;
            $passwordResetRequest->firstname = $user->firstname;
            $passwordResetRequest->lastname = $user->lastname;
            $passwordResetRequest->email = $user->email;
            $passwordResetRequest->save();
            return response()->json([
                "message" => "Password Reset sent. Contact Administrator for your new Password."
            ], 200);
        
        }
        return response()->json([
            "message" => "User does not exist"
        ], 400);
   }

   public function getAllPasswordResetRequests()
   {
        $passwordResetRequests = PasswordResetRequest::all();
        if(count($passwordResetRequests) > 0)
        {
            return response()->json([
                "message" => "All password reset requests fetched",
                "passwordResetRequests" => $passwordResetRequests
            ], 200);
        }
        return response()->json([
            "message" => "No password reset requests",
        ], 400);
   }

   public function processPasswordResetRequest(Request $request, $id) 
   {
        $passwordResetRequest = PasswordResetRequest::find($id);
        if(!$passwordResetRequest){
            return response()->json([
                "message" => "Request does not exist."
            ], 422);

        }
        if($passwordResetRequest->request_status === 0){
            return response()->json([
                "message" => "Request already processed."
            ], 422);

        }
        $validated = Validator::make($request->all(),[
            'password' =>'required',
        ]);
        if($validated->fails()){
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
            ],422);
        }
        $user = User::where('email',$passwordResetRequest->email)->first();
        if(!$user){
            return response()->json([
                "message" => "User not found!"
            ], 422);
        }
        $user->password = bcrypt($request->password);
        $user->update();
        $passwordResetRequest->request_status = 0;
        $passwordResetRequest->update();
        return response()->json([
            "message" => "Password updated successfully"
        ], 200);
    
   }

   public function deletePasswordResetRequest($id)
   {
        $passwordResetRequest = PasswordResetRequest::find($id);
        if(!$passwordResetRequest)
        {
            return response()->json([
                "message" => "Request Not found."
            ], 400);
        }
        $passwordResetRequest->delete();
        return response()->json([
            "message" => "Request deleted."
        ], 201);

   }
}
