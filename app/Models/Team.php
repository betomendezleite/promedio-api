<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'teamAbv',
        'teamCity',
        'teamName',
        'teamID',
        'division',
        'conferenceAbv',
        'nbaComLogo1',
        'espnLogo1',
        'conference',
        'ppg',
        'oppg',
        'defensivePtsAway',
        'defensivePtsHome',
        'ofensivePtsAway',
        'ofensivePtsHome',
        // Nuevas columnas
        'top_performers_blk_total',
        'top_performers_blk_player_id',
        'ast_total',
        'ast_player_id',
        'tptfgm_total',
        'tptfgm_player_id',
        'stl_total',
        'stl_player_id',
        'tov_total',
        'tov_player_id',
        'pts_total',
        'pts_player_id',
        'reb_total',
        'reb_player_id',
    ];
}
