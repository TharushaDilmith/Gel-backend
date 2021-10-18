<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //login
    public function login(Request $request)
    {
        //validate incoming request
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $credentials = $request->only(['email', 'password']);

        //check credentials
        if(auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();

            //add role to user
            $userRole = $user->role()->first();
    

            //create token
            $token = $user->createToken($user->email .'_' .now(),[$userRole->role])->accessToken;

            return response()->json(['token' => $token], 200);

        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        } 

    }
}
