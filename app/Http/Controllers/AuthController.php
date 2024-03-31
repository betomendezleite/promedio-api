<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->login)->first();

        if (!$user) {
            $person = Person::where('email', $request->login)
                ->orWhere('phone', $request->login)
                ->first();

            if (!$person) {
                // throw ValidationException::withMessages(['login' => 'Invalid login credentials']);
                return response()->json(
                    [
                        "message" => "Error credenciales"
                    ],
                    401
                );
            }

            $user = User::where('person_id', $person->id)->first();

            if (!$user || !password_verify($request->password, $user->password)) {
                // throw ValidationException::withMessages(['login' => 'Invalid login credentials']);
                return response()->json(
                    [
                        "message" => "Error credenciales"
                    ],
                    401
                );
            }
        } else {
            if (!password_verify($request->password, $user->password)) {
                // throw ValidationException::withMessages(['login' => 'Invalid login credentials']);
                return response()->json(
                    [
                        "message" => "Error credenciales"
                    ],
                    401
                );
            }
        }

        // Autenticar al usuario
        Auth::login($user);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user_id' => $user->id,
            'person_id' => optional($user->person)->id,
            'message' => 'Login successful'
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }
}
