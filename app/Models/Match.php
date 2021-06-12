<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    protected $table = 'matches';
 
    protected $fillable = [
        'user_id', 
        'name'
    ]; 

    public static function randomTeams($request){ 
        // Não permitir total de confirmados menor que Nj*2
        if(count($request->players) < $request->number * 2){                
            throw new \Exception("Número de confirmados não permite gerar ao menos dois times com ".$request->number." jogadores", 1);
        } 
        
        $times = floor(count($request->players) / $request->number); // número de times inteiros, arredondaar para menos se for um numero quebrado e pegar o resto se existir abaixo
        $resto = (count($request->players) % $request->number); // resto de jogadores pra fora de um time completo se a divisão não for completa
        $players_number = $request->number; 
          
        //Quantidade de goleiros permitidos de acordo à quantidade de times existentes
        if($resto == 0){
            $numero_goal = $times;
        }else{
            $numero_goal = $times + 1;
        }
        
        //Separar os jogadores de linha de goleiros
        $goalkeepers = [];
        $players = [];

        foreach($request->players as $id){
            $playe = Player::find($id);
            
            if($playe->goalkeeper) {
                $goalkeepers[] = $playe;
            }else{
                $players[] = $playe;
            }
        }
         
        // Validar se quantidade de goleiros é válida, ou seja, para validar no máximo 1 goleiro por time
        $goal_post_count = count($goalkeepers);             
        if($goal_post_count > $numero_goal){                
            throw new \Exception("Número de goleiros é maior que o número de times, impossibilitando ter 1 goleiro por time ", 1);
        }
                
        //Sortear ordem de array
        shuffle($players);        
        $teams = Match::generateList($goalkeepers,$players,$players_number,$resto); 
        
        return $teams;
    }

    private static function generateList($goalkeepers,$players,$players_number,$resto){
        $team = Match::listPlayers($goalkeepers,$players,$players_number);                        
        $pesos = Match::calculateWeight($team,$resto); 
        if(!$pesos){
            throw new \Exception("Peso dos times ficou desbalanceado, tente novamente", 1);
        }
        return $team;
    }

    private static function listPlayers($goalkeepers,$players,$players_number){
        $team = []; 
        //Distribuir o array de times, com no máximo 1 goleiro por time
        foreach($goalkeepers as $goal){                 
            for($i=0; $i < $players_number - 1 ; $i++){                     
                if(isset($players[$i])){
                    $team[$goal->id][] = $players[$i];
                    unset($players[$i]);
                } 
            }
            $team[$goal->id][] = $goal;
            $players = array_values($players);  
        } 
    
        //se sobrar jogadores sem time e sem goleiro  
        $rest = count($players);
        
        while($rest>0){ 
            $temp = array_slice($players,0, $players_number);
            foreach($temp as $key=>$tp){
                unset($players[$key]); 
            }
            $players = array_values($players);  
            $team[] = $temp;  
            $rest = count($players);             
        }
               
        return $team;
    }

    private static function calculateWeight($team,$resto){
        foreach($team as $key => $equipe){
            $pesos[$key] = 0;

            foreach($equipe as $play){                    
                if(isset($play->level)) $pesos[$key] += $play->level;
            }                
        }

        if($resto != 0){
            array_pop($pesos);
        } 

        $temp = $pesos;
        $max = max($pesos);
        $min = min($temp);

        $x = (($min*100)/$max);
         
        if (100 - $x > 25) return false;

        return true;
    } 
}
