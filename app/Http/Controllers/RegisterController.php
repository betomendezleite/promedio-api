<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function registeruser(Request $request)
    {
        try {
            // Crear la persona
            $person = Person::create([
                "name" => $request->name,
                "lastname" => $request->lastname,
                "phone" => $request->phone,
                "email" => $request->email
            ]);

            if (!$person) {
                throw new \Exception('Error al registrar la persona');
            }

            // Buscar el usuario por referencia
            $affiliate = $request->affiliate;
            $ref = User::where('username', $affiliate)->first();

            $fechaActual = Carbon::now();

            // Sumamos 365 días
            $fechaCalculada = $fechaActual->addDays(365);
            $plano_padrao = 2;

            if ($ref) {

                $user = User::create([
                    "username" => $request->username,
                    "password" =>  Hash::make($request->password),
                    "reference" => $ref->id,
                    "validity_date" => $fechaCalculada,
                    "active" => 1,
                    "person_id" => $person->id,
                    "subscription_id" => $plano_padrao,
                ]);

                $wallet = Wallet::create([
                    "user_id" => $user->id,
                    "total_amount" => 0,
                    "payment_amount" => 0,
                ]);

                return response()->json(['message' => 'Registro exitoso', 'data' => $person], 201);
            } else {
                $user = User::create([
                    "username" => $request->username,
                    "password" => Hash::make($request->password),
                    "reference" => 1,
                    "validity_date" => $fechaCalculada,
                    "active" => 1,
                    "person_id" => $person->id,
                    "subscription_id" => $plano_padrao,
                ]);
                $wallet = Wallet::create([
                    "user_id" => $user->id,
                    "total_amount" => 0,
                    "payment_amount" => 0,
                ]);
                return response()->json(['message' => 'Registro exitoso', 'data' => $person], 201);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
