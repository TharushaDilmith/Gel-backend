<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        //request data
        $credentials = $request->only(['email', 'password']);

        //check credentials
        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            //add role to user
            $userRole = $user->role()->first();

            //create token
            $token = $user->createToken($user->email . '_' . now(), [$userRole->role])->accessToken;

            //return response
            return response()->json(['token' => $token], 200);

        } else {
            //return error
            return response()->json(['error' => 'Please enter valid username and password!'], 401);
        }
    }
    //logout
    public function logout(Request $request)
    {
        //revoke token
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    //register
    public function register(Request $request)
    {
        //validate incoming request
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'c_password' => 'required|string|same:password',
        ]);

        //create new user
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //add role to user
        if ($user) {
            //validate user 
            auth()->attempt(['email' => $request->email, 'password' => $request->password]);

            //get user
            $user = auth()->user();

            //get user role
            $userRole = $user->role()->first();

            //create token
            $token = $user->createToken($user->email . '_' . now(), [$userRole->role])->accessToken;

            //send mail to admin
            $adminMailDetials =[
                'subject' => 'New user registered',
                'message' => 'New user registered',
                'name' => $user->firstname . ' ' . $user->lastname,
                'email' => $user->email,
            ];

            Mail::to('tharushadilmith99@gmail.com')->send(new \App\Mail\AdminMail($adminMailDetials));

            //send mail to user
            $userDetails = [
                'email' => $request->email,
                'subject' => 'Welcome to GEL',
                'name' => $request->firstname ,
                'message' => 'You have successfully registered to GEL. Please login to continue.',
            ];

            Mail::to($request->email)->send(new \App\Mail\UserMail($userDetails));

           

            //return response
            return response()->json([
                'token' => $token,
            ], 201);
        }

    }

}
