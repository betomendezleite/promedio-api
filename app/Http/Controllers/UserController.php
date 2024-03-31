<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['data' => $user], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',
            'password' => 'required|string',
            'active' => 'required|boolean',
            'person_id' => 'required|exists:persons,id',
            'subscription_id' => 'required|exists:subscriptions,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'active' => $request->input('active'),
            'person_id' => $request->input('person_id'),
            'subscription_id' => $request->input('subscription_id'),
        ]);

        return response()->json(['message' => 'User created', 'data' => $user], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username,' . $id,
            'password' => 'nullable|string',
            'active' => 'required|boolean',
            'person_id' => 'required|exists:persons,id',
            'subscription_id' => 'required|exists:subscriptions,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 422);
        }

        // Actualizar solo si se proporciona una nueva contraseña
        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->update([
            'username' => $request->input('username'),
            'active' => $request->input('active'),
            'person_id' => $request->input('person_id'),
            'subscription_id' => $request->input('subscription_id'),
        ]);

        return response()->json(['message' => 'User updated', 'data' => $user], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted'], 200);
    }
}
