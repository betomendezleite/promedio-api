<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stat;

class StatController extends Controller
{
    public function index()
    {
        $stats = Stat::all();
        return response()->json($stats);
    }

    public function show($id)
    {
        $stat = Stat::findOrFail($id);
        return response()->json($stat);
    }

    public function store(Request $request)
    {
        // Validar los datos del request aquí si es necesario

        $stat = Stat::create($request->all());

        return response()->json($stat, 201);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del request aquí si es necesario

        $stat = Stat::findOrFail($id);
        $stat->update($request->all());

        return response()->json($stat, 200);
    }

    public function destroy($id)
    {
        $stat = Stat::findOrFail($id);
        $stat->delete();

        return response()->json(null, 204);
    }
}
