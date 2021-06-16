<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchRequest;
use App\Http\Requests\MatchSortRequest;
use Illuminate\Http\Request;
use App\Models\Matche;
use App\Models\Player;
use App\Models\TeamPlayer;

use Auth;
use Session;

class MatchController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $itens =  $user->matchs()->paginate(10);
        return view('match.index',compact('itens')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $players = Player::all();
        return view('match.create',compact('players')); 
    }


    /**
     * Return array list of players on random teams
     *
     * @return \Illuminate\Http\Response json
     */
    public function sort_teams(MatchRequest $request){
        try {   
            // Sortear no modelo as listas aleatórias de jogadores
            $itens = Matche::randomTeams($request);   
            return view('match.preview',compact('itens'));
        } catch (\Throwable $th) {
            $response = $th->getMessage();
            $status = 422;
        }
        return response()->json($response,$status);
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MatchRequest $request)
    {
        $data = $request->all();
        
        try {
            $user = Auth::user();
            $match = $user->matchs()->create([
                'name'=>$request->name
            ]);

            foreach($request->players as $team){
                $tea = $match->teams()->create(['user_id'=>$user->id]);                
                foreach($team as $player){ 
                    $tea->players()->create(['player_id'=>$player['id']]);
                }                
            }   

            Session::flash('message', 'A partida foi salva com sucesso!');
            Session::flash('color', 'green');
        } catch (\Throwable $th) {
            Session::flash('message', 'Não foi possível salvar a partida!'); 
            Session::flash('color', 'red');
        }

	    return redirect()->route('match.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $item = Matche::findorFail($request->id);  
            $teams = $item->teams()->with('players')->get(); 
        }catch(\Throwable $th){
            Session::flash('message', 'Não foi possível visualizar a partida!'); 
            Session::flash('color', 'red');
            return redirect()->route('match.index');
        }
        return view('match.show',compact('teams'));
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        try {
            $item = Matche::findorFail($id); 

            //deletar dados relacionados
            $arr = $item->teams()->pluck('id')->toArray();
            $data = TeamPlayer::whereIn('team_id',$arr)->delete();  
            $item->delete();

        }catch(\Throwable $th){
            
            Session::flash('message', 'Não foi possível excluir a partida!'); 
            Session::flash('color', 'red');
            return redirect()->route('match.index');
        }
        Session::flash('message', 'Partida excluida com sucesso!'); 
        Session::flash('color', 'red');
        return redirect()->route('match.index'); 
    }
}
