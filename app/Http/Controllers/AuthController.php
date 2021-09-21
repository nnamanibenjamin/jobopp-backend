<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
//$table->string('first_name');
//$table->string('last_name');
//$table->string('profile_picture')->nullable();
//$table->text('bio')->nullable();
//$table->string('email')->unique();

public function authFailed(){
    return response('unathenticated', 401);
}
    public function register(Request $request){
     $validator = Validator::make($request->all(),[
         'firstName' =>'required|string|max:255',
         'lastName' =>'required|string|max:255',
         'email' =>'required|string|email|unique:users|max:255',
         'password' =>'required|string|max:255|min:6|confirmed',
     ]);
     if ($validator->fails()){
       return response(['error' => $validator->errors()], 422);
     }

     $user = new User();
     $user->first_name = $request->firstName;
     $user->last_name = $request->lastName;
     $user->email = $request->email;
     $user->email = $request->email;
     $user->password = bcrypt($request->password);
     $user->save();

     //Token
        $tokenResult =  $user->createToken("Personal Access Token");
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return  response([
            "accessToken" =>$tokenResult->accessToken,
            "tokenType" => "Bearer",
            "expiresAt" =>Carbon::parse($token->expires_at)->toDateTimeString()
        ], 200);

    }


    public function login(Request $request){
        $validator = Validator::make($request->all(),[

            'email' =>'required|string|email|max:255',
            'password' =>'required|string|max:255',
        ]);
        if ($validator->fails()){
            return response(['error' => $validator->errors()], 422);
        }

        $credentials = \request(['email', 'password']);

         if (Auth::attempt($credentials)){
             $user = $request -> user();
             //Token
             $tokenResult =  $user->createToken("Personal Access Token");
             $token = $tokenResult->token;
             $token->expires_at = Carbon::now()->addWeeks(1);
             $token->save();

             return  response([
                 "accessToken" =>$tokenResult->accessToken,
                 "tokenType" => "Bearer",
                 "expiresAt" =>Carbon::parse($token->expires_at)->toDateTimeString()
             ], 200);
         }

    }

    public function logout(Request $request){
      $request->user()->token()->revoke();
      return  response('successfully logged out', 200);
    }

    public function user(Request  $request){
        return $request->user();
    }
}
