<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use GuzzleHttp\Client;

class PlayerController extends Controller
{
    public function fetchAndStorePlayers($plyrID)
    {
        // Verificar si existe un jugador con el playerID proporcionado
        $player = Player::where('playerID', $plyrID)->first();

        // Si el jugador no existe, crear un nuevo registro en el modelo Player
        if (!$player) {
            $client = new Client();
            $rapidKey = env('RAPIDKEY');

            try {
                // Realizar la solicitud a la API para obtener los datos del jugador
                $response = $client->request('GET', 'https://tank01-fantasy-stats.p.rapidapi.com/getNBAPlayerInfo?playerID=' . $plyrID . '&statsToGet=averages', [
                    'headers' => [
                        'X-RapidAPI-Host' => 'tank01-fantasy-stats.p.rapidapi.com',
                        'X-RapidAPI-Key' =>  $rapidKey,
                    ],
                ]);

                // Decodificar la respuesta JSON
                $playerData = json_decode($response->getBody(), true);

                // Crear un nuevo jugador con los datos obtenidos de la API
                $player = Player::create([
                    'playerID' => $playerData['playerID'],
                    'team' => $playerData['team'],
                    'longName' => $playerData['longName'],
                    'teamID' => $playerData['teamID'],
                ]);
            } catch (\Exception $e) {
                // Manejar cualquier excepción que pueda ocurrir
                return response()->json(['error' => 'Error al obtener datos de la API'], 500);
            }
        }

        // Retornar los datos del jugador en formato JSON
        return response()->json($player);
    }
}
