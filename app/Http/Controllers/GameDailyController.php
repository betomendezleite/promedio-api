<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameDaily;
use GuzzleHttp\Client;

class GameDailyController extends Controller
{
    public function index()
    {
        $client = new Client();
        $rapidKey = env('RAPIDKEY');
        $date = date('Ymd');
        $response = $client->request('GET', 'https://tank01-fantasy-stats.p.rapidapi.com/getNBAGamesForDate?gameDate=' . $date, [
            'headers' => [
                'X-RapidAPI-Host' => 'tank01-fantasy-stats.p.rapidapi.com',
                'X-RapidAPI-Key' =>        $rapidKey,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        // Guardar los resultados en la base de datos
        foreach ($data['body'] as $game) {
            GameDaily::create([
                'gameID' => $game['gameID'],
                'teamIDAway' => $game['teamIDAway'],
                'away' => $game['away'],
                'gameDate' => $game['gameDate'],
                'teamIDHome' => $game['teamIDHome'],
                'home' => $game['home'],
            ]);
        }

        return response()->json(['message' => 'Datos guardados exitosamente en la base de datos']);
    }

    public function getByGameDate($gameDate)
    {
        $games = GameDaily::where('gameDate', $gameDate)->get();

        if ($games->isEmpty()) {
            return response()->json(['message' => 'No se encontraron juegos para la fecha proporcionada'], 404);
        }

        return response()->json($games);
    }
}
