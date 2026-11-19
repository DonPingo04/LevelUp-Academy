<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username'    => 'required',
            'password' => 'required',
        ]);

        $user = Usuario::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) 
        {
            throw ValidationException::withMessages([
                'username' => ['Las credenciales proporcionadas no son correctas.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout exitoso']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}   
