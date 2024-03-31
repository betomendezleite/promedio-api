<?php

namespace App\Http\Controllers;

use App\Models\BettingOdds;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BettingOddings extends Controller
{
    public function index()
    {
        $client = new Client();
        // $date = date('Ymd');
        $date = '20240214';
        $rapidKey = env('RAPIDKEY');
        $response = $client->request('GET', 'https://tank01-fantasy-stats.p.rapidapi.com/getNBABettingOdds?gameDate=' . $date, [
            'headers' => [
                'X-RapidAPI-Host' => 'tank01-fantasy-stats.p.rapidapi.com',
                'X-RapidAPI-Key' => $rapidKey,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        // Verificar si hay datos en la tabla
        if (BettingOdds::count() > 0) {
            // Si hay datos, borrarlos
            BettingOdds::truncate();
        }

        $conteo = count($data['body']);
        $datos = $data['body'];

        foreach ($data['body'] as $key => $value) {
            BettingOdds::create([
                'teamIDHome' => $value['teamIDHome'],
                'teamIDAway' => $value['teamIDAway'],
                'totalUnder' => $value['fanduel']['totalUnder'],
                'awayTeamSpread' => $value['fanduel']['awayTeamSpread'],
                'awayTeamSpreadOdds' => $value['fanduel']['awayTeamSpreadOdds'],
                'homeTeamSpread' => $value['fanduel']['homeTeamSpread'],
                'homeTeamSpreadOdds' => $value['fanduel']['homeTeamSpreadOdds'],
                'totalOverOdds' => $value['fanduel']['totalOverOdds'],
                'totalUnderOdds' => $value['fanduel']['totalUnderOdds'],
                'awayTeamMLOdds' => $value['fanduel']['awayTeamMLOdds'],
                'homeTeamMLOdds' => $value['fanduel']['homeTeamMLOdds'],
                'totalOver' => $value['fanduel']['totalOver'],
            ]);
        }

        return response()->json(['message' => 'BettingOdds guardados exitosamente en la base de datos']);
    }

    public function getByTeamIDs($teamIDHome, $teamIDAway)
    {
        // Realizar la consulta SQL
        $bettingOdds = BettingOdds::where('teamIDHome', $teamIDHome)
            ->where('teamIDAway', $teamIDAway)
            ->get();

        // Verificar si se encontraron registros
        if ($bettingOdds->isEmpty()) {
            return response()->json(['message' => 'No se encontraron registros para los IDs de equipo proporcionados'], 404);
        }

        // Retornar los registros encontrados
        return response()->json($bettingOdds);
    }
}
