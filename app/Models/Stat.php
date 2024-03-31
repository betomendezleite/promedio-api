<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'blk',
        'fga',
        'DefReb',
        'ast',
        'ftp',
        'tptfgp',
        'tptfgm',
        'trueShootingPercentage',
        'stl',
        'fgm',
        'pts',
        'reb',
        'fgp',
        'effectiveShootingPercentage',
        'fta',
        'mins',
        'gamesPlayed',
        'TOV',
        'tptfga',
        'OffReb',
        'ftm',
    ];
}
