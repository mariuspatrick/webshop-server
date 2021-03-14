<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\Hash;

// use Laravel\Passport\Client;

class UserController extends Controller
{
    function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('LaravelAuthApp')->accessToken;

        $user->cart()->create([
            'user_id' => $user->id
        ]);

        return response()->json(['token' => $token], 200);
    }
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('LaravelAuthApp')->accessToken;
                return response()->json([
                    'token' => $token,
                    'name' => $user->name
                ], 200);
            } else {
                return response()->json(['error' => 'Invalid password'], 422);
            }
        } else {
            return response()->json(['error' => "User with this email doesn't exist"], 422);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            dd($request->user()->tokens);
        }
    }
}
