<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request)
    {
        $rules = [
            'user_name' => 'required|string',
            'password' => 'required|string'
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }
        $user = User::where('user_name', $request->user_name)->first();
        $rol = User::where('rol', $request->user_name)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid login details'
            ], 401);
        }
        return response()->json([
            'status' => true,
            'user' => $user,
            'rol' => $rol,
            'token' => $user->createToken('token')->plainTextToken
        ], 200);
    }
    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        // Revocar el token actual del usuario
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function verify(Request $request)
{
    return response()->json(['message' => 'Token is valid', 'user' => $request->user()], 200);
}
}
