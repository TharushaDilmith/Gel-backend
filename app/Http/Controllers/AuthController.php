<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();

            //add role to user
            $userRole = $user->role()->first();

            //create token
            $token = $user->createToken($user->email . '_' . now(), [$userRole->role])->accessToken;

            return response()->json(['token' => $token], 200);

        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }

    }
    //logout
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    //passport register with token
    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'c_password' => 'required|string|same:password',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //add role to user
        if ($user) {
            auth()->attempt(['email' => $request->email, 'password' => $request->password]);
            $user = auth()->user();

            //add role to user
            $userRole = $user->role()->first();

            //create token
            $token = $user->createToken($user->email . '_' . now(), [$userRole->role])->accessToken;

            return response()->json([
                'token' => $token,
            ], 201);
        }

    }

}
