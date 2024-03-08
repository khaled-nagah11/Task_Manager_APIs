<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validated = $request->validate([
           'name'=>'required|min:5|max:255',
           'email'=>'required|min:10|max:255|email|unique:users,email',
           'password'=>'required|confirmed|min:6',
        ]);

        $user = User::create($validated);
        return response()->json([
           'data'=>$user,
           'access_token'=>$user->createToken('api_token')->plainTextToken,
           'token_type'=>'Bearer',
        ] , 201 );
    }

    public function login (Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        if (! Auth::attempt($validated)){
            return response()->json([
                'message'=>'invalid email or password'
            ],401);
        }

        $user = User::where('email' , $validated['email'])->first();
        return response()->json([
            'access_token'=>$user->createToken('api_token')->plainTextToken,
            'token_type'=>'Bearer'
        ]);
    }
}
