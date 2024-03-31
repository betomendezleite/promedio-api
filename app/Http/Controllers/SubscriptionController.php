<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::all();
        return response()->json(['data' => $subscriptions], 200);
    }

    public function show($id)
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }

        return response()->json(['data' => $subscription], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'validate' => 'required|integer',
            'price' => 'required|numeric',
            'reference_payment_percentage' => 'required',
            'recomend' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 422);
        }

        $subscription = Subscription::create($request->all());

        return response()->json(['message' => 'Subscription created', 'data' => $subscription], 201);
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'validate' => 'required|integer',
            'price' => 'required|numeric',
            'reference_payment_percentage' => 'required',
            'recomend' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 422);
        }

        $subscription->update($request->all());

        return response()->json(['status' => 200, 'message' => 'Subscription updated', 'data' => $subscription], 200);
    }

    public function destroy($id)
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }

        $subscription->delete();

        return response()->json(['status' => 200, 'message' => 'Eliminado correctamente'], 200)->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    }
}
