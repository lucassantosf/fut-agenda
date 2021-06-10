<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchPlayer extends Model
{
    use HasFactory;

    protected $table = 'match_players';
 
    protected $fillable = [
        'user_id', 
        'match_id', 
        'player_id', 
    ]; 

}
