<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BettingOdds extends Model
{
    use HasFactory;

    protected $table = 'bettingoddings';

    protected $fillable = [
        'teamIDHome',
        'teamIDAway',
        'totalUnder',
        'awayTeamSpread',
        'awayTeamSpreadOdds',
        'homeTeamSpread',
        'homeTeamSpreadOdds',
        'totalOverOdds',
        'totalUnderOdds',
        'awayTeamMLOdds',
        'homeTeamMLOdds',
        'totalOver',
    ];
}
