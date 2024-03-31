<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return response()->json(['data' => $payments], 200);
    }

    public function show($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        return response()->json(['data' => $payment], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'person_id' => 'required|exists:persons,id',
            'id_payment' => 'required|string',
            'status' => 'string',
            'type' => 'string', // Agregamos validación para 'type'
            'subscription' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 422);
        }

        $payment = Payment::create($request->all());

        return response()->json(['message' => 'Payment created', 'data' => $payment], 201);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'person_id' => 'required|exists:persons,id',
            'id_payment' => 'required|string',
            'status' => 'string',
            'type' => 'string',
            'subscription' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 422);
        }

        $payment->update($request->all());

        return response()->json(['message' => 'Payment updated', 'data' => $payment], 200);
    }

    public function destroy($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $payment->delete();

        return response()->json(['message' => 'Payment deleted'], 200);
    }
}
