<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use App\Models\Team;
use GuzzleHttp\Client;

class RefreshTeamsController extends Controller
{
    public function refreshTeams()
    {
        // Verificar si hay datos en la tabla
        if (Team::count() > 0) {
            // Si hay datos, borrarlos
            Team::truncate();
        }

        // Ejecutar el script para obtener nuevos datos
        $client = new Client();
        $rapidKey = env('RAPIDKEY');

        $response = $client->request('GET', 'https://tank01-fantasy-stats.p.rapidapi.com/getNBATeams?schedules=true&rosters=true&topPerformers=true&teamStats=true&statsToGet=averages', [
            'headers' => [
                'X-RapidAPI-Host' => 'tank01-fantasy-stats.p.rapidapi.com',
                'X-RapidAPI-Key' =>  $rapidKey,
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        // dd($data);
        // Rellenar la tabla con los nuevos datos
        foreach ($data['body'] as $teamData) {
            $ppg = isset($teamData['ppg']) ? $teamData['ppg'] : 0; // Valor predeterminado si 'ppg' está ausente
            $oppg = isset($teamData['oppg']) ? $teamData['oppg'] : 0; // Valor predeterminado si 'oppg' está ausente

            Team::create([
                'teamAbv' => $teamData['teamAbv'],
                'teamCity' => $teamData['teamCity'],
                'teamName' => $teamData['teamName'],
                'teamID' => $teamData['teamID'],

                'division' => $teamData['division'],
                'conferenceAbv' => $teamData['conferenceAbv'],
                'nbaComLogo1' => $teamData['nbaComLogo1'],
                'espnLogo1' => $teamData['espnLogo1'],
                'conference' => $teamData['conference'],

                'ppg' => $ppg,
                'oppg' => $oppg,
                'defensivePtsAway' => $teamData['defensiveStats']['ptsAway'] ?? 0,
                'defensivePtsHome' => $teamData['defensiveStats']['ptsHome'] ?? 0,
                'ofensivePtsAway' => $teamData['offensiveStats']['ptsAway'] ?? 0,
                'ofensivePtsHome' => $teamData['offensiveStats']['ptsHome'] ?? 0,


                // Nuevas columnas
                'top_performers_blk_total' => $teamData['topPerformers']['blk']['total'],
                'top_performers_blk_player_id' => $teamData['topPerformers']['blk']['playerID'][0],
                'ast_total' => $teamData['topPerformers']['ast']['total'] ?? 0,
                'ast_player_id' => $teamData['topPerformers']['ast']['playerID'][0] ?? null,
                'tptfgm_total' => $teamData['topPerformers']['tptfgm']['total'] ?? 0,
                'tptfgm_player_id' => $teamData['topPerformers']['tptfgm']['playerID'][0] ?? null,
                'stl_total' => $teamData['topPerformers']['stl']['total'] ?? 0,
                'stl_player_id' => $teamData['topPerformers']['stl']['playerID'][0] ?? null,
                'tov_total' => $teamData['topPerformers']['TOV']['total'] ?? 0,
                'tov_player_id' => $teamData['topPerformers']['TOV']['playerID'][0] ?? null,
                'pts_total' => $teamData['topPerformers']['pts']['total'] ?? 0,
                'pts_player_id' => $teamData['topPerformers']['pts']['playerID'][0] ?? null,
                'reb_total' => $teamData['topPerformers']['reb']['total'] ?? 0,
                'reb_player_id' => $teamData['topPerformers']['reb']['playerID'][0] ?? null,
            ]);
        }

        return response()->json(['message' => 'Datos actualizados correctamente']);
    }

    public function getByTeamID($teamID)
    {
        // Obtener el equipo
        $team = Team::where('teamID', $teamID)->first();

        if (!$team) {
            return response()->json(['message' => 'No se encontró ningún equipo con el ID proporcionado'], 404);
        }

        // Obtener los jugadores asociados al equipo
        $players = Player::whereIn('playerID', [
            $team->top_performers_blk_player_id,
            $team->ast_player_id,
            $team->tptfgm_player_id,
            $team->stl_player_id,
            $team->tov_player_id,
            $team->pts_player_id,
            $team->reb_player_id,
        ])->get();

        // Adjuntar los jugadores al equipo
        $team->players = $players;

        return response()->json($team);
    }
}
