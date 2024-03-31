<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDaily extends Model
{
    use HasFactory;

    protected $table = 'game_daily';
    protected $fillable = [
        'gameID',
        'teamIDAway',
        'away',
        'gameDate',
        'teamIDHome',
        'home',
    ];
}
