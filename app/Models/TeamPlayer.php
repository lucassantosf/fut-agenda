<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamPlayer extends Model
{
    use HasFactory;

    protected $table = 'team_players';
 
    protected $fillable = [
        'team_id', 
        'player_id'
    ]; 

    public function player(){ 
        return $this->belongsTo(Player::class,'player_id'); 
    }
}
