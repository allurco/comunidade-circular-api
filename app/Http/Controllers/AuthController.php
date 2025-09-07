<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $r) {
        $data = $r->validate([
            'name' => 'required|string',
            'email'=> 'required|email|unique:users,email',
            'password' => ['required', Password::min(6)]
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email'=> $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $token = $user->createToken('mobile')->plainTextToken;
        return response()->json(['user'=>$user, 'token'=>$token], 201);
    }

    public function login(Request $r) {
        $data = $r->validate([
            'email'=> 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email',$data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message'=>'Credenciais inválidas'], 422);
        }
        $token = $user->createToken('mobile')->plainTextToken;
        return response()->json(['user'=>$user, 'token'=>$token]);
    }

    public function logout(Request $r) {
        $r->user()->currentAccessToken()->delete();
        return response()->json(['ok'=>true]);
    }
}
