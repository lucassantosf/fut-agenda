<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'teams';
 
    protected $fillable = [
        'user_id', 
        'match_id'
    ]; 

    public function players(){ 
        return $this->hasMany(TeamPlayer::class,'team_id'); 
    }
}
