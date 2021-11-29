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

        try {
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

                //check role and redirect

                return response()->json([
                    'status' => 'success',
                    'message' => 'Login Successful',
                    'data' => [
                        'user' => $user,
                        'token' => $token,
                    ],
                ], 200);

            } else {
                //return error
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid Credentials',
                ], 200);

            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }
    //logout
    public function logout(Request $request)
    {
        try {
            //revoke token
            $request->user()->token()->revoke();
            return response()->json([
                'message' => 'Successfully logged out',
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }
    //register
    public function register(Request $request)
    {
        try {
            //validate incoming request
            $request->validate([
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string',
                // 'c_password' => 'required|string|same:password',
            ]);

            //create new user
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            //check if user was created
            if ($user) {

                //send mail to admin
                $adminMailDetials = [
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
                    'name' => $request->firstname,
                    'message' => 'You have successfully registered to GEL. Please login to continue.',
                ];

                Mail::to($request->email)->send(new \App\Mail\UserMail($userDetails));

                //return response
                return response()->json([
                    'status' => 'success',
                    'message' => 'User  registered successfully, Please login to continue',
                    'data' => $user,
                ], 200);

            } else {
                //return error
                return response()->json([
                    'status' => 'error',
                    'message' => 'User could not be created',
                ], 200);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    //admin login
    public function adminLogin(Request $request)
    {

        try {
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

                if ($userRole->role == 'admin') {
                    //create token
                    $token = $user->createToken($user->email . '_' . now(), [$userRole->role])->accessToken;

                    //check role and redirect

                    return response()->json([
                        'success' => true,
                        'message' => 'Login Successful',
                        'data' => [
                            'user' => $user,
                            'token' => $token,
                        ],
                    ], 200);
                } else {
                    //return error
                    return response()->json([
                        'success' => false,
                        'message' => 'UnAuthorized',
                    ], 200);

                }

            } else {
                //return error
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid Credentials',
                ], 200);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

}
