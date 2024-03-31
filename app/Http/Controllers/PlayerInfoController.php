<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Stat;
use GuzzleHttp\Client;

class PlayerInfoController extends Controller
{
    public function index(Request $request)
    {
        $playerId = $request->id;
        $player = Player::where('playerID', $playerId)->first();

        // Si el jugador no existe en la base de datos, obtenerlo de la API externa
        if (!$player) {
            $client = new Client();

            try {
                // Realizar la solicitud a la API externa
                $response = $client->request('GET', 'https://tank01-fantasy-stats.p.rapidapi.com/getNBAPlayerInfo', [
                    'query' => [
                        'playerID' => $playerId,
                        'statsToGet' => 'averages',
                    ],
                    'headers' => [
                        'X-RapidAPI-Host' => 'tank01-fantasy-stats.p.rapidapi.com',
                        'X-RapidAPI-Key' => 'f8320758b1msh588b3de42b2ee0bp186d45jsn64865366f867',
                    ],
                ]);

                // Decodificar la respuesta JSON
                $playerData = json_decode($response->getBody(), true);
                /*               \Log::info('Datos del jugador recibidos:', $playerData['body']['pos']); */

                $player = Player::create([
                    'playerID' => $playerId,
                    'longName' => $playerData['body']['longName'],
                    'pos' => $playerData['body']['pos'],
                    'team' => $playerData['body']['team'],
                    'img' => $playerData['body']['nbaComHeadshot'],
                    'teamID' => $playerData['body']['teamID']
                ]);


                // Crear o actualizar las estadísticas del jugador
                $stat = Stat::updateOrCreate(
                    ['player_id' => $playerId],
                    [
                        'player_id' => $playerId,
                        'blk' => $playerData['body']['stats']['blk'],
                        'fga' => $playerData['body']['stats']['fga'],
                        'DefReb' => $playerData['body']['stats']['DefReb'],
                        'ast' => $playerData['body']['stats']['ast'],
                        'ftp' => $playerData['body']['stats']['ftp'],
                        'tptfgp' => $playerData['body']['stats']['tptfgp'],
                        'tptfgm' => $playerData['body']['stats']['tptfgm'],
                        'trueShootingPercentage' => $playerData['body']['stats']['trueShootingPercentage'],
                        'stl' => $playerData['body']['stats']['stl'],
                        'fgm' => $playerData['body']['stats']['fgm'],
                        'pts' => $playerData['body']['stats']['pts'],
                        'reb' => $playerData['body']['stats']['reb'],
                        'fgp' => $playerData['body']['stats']['fgp'],
                        'effectiveShootingPercentage' => $playerData['body']['stats']['effectiveShootingPercentage'],
                        'fta' => $playerData['body']['stats']['fta'],
                        'mins' => $playerData['body']['stats']['mins'],
                        'gamesPlayed' => $playerData['body']['stats']['gamesPlayed'],
                        'TOV' => $playerData['body']['stats']['TOV'],
                        'tptfga' => $playerData['body']['stats']['tptfga'],
                        'OffReb' => $playerData['body']['stats']['OffReb'],
                        'ftm' => $playerData['body']['stats']['ftm'],
                    ]
                );

                if (!$stat) {
                    throw new \Exception('Error al crear o actualizar las estadísticas del jugador.');
                }
            } catch (\Exception $e) {
                \Log::error('Error al procesar los datos del jugador: ' . $e->getMessage());
                // Manejar cualquier error que pueda ocurrir al hacer la solicitud a la API
                return response()->json(['error' => 'No se pudo obtener la información del jugador de la API'], 500);
            }
        }



        // Realizar el join entre Player y Stat usando playerId y player_id
        $playerWithStats = Player::leftJoin('stats', 'players.playerId', '=', 'stats.player_id')
            ->select('players.*', 'stats.*')
            ->where('players.playerId', $playerId)
            ->first();

        return response()->json($playerWithStats);
    }
}
