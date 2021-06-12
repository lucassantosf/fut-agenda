<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Match;
use App\Models\Player;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itens = Match::paginate(20);
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
    public function sort_teams(Request $request){
        try {   
            $itens = Match::randomTeams($request);                    
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
    public function store(Request $request)
    {
        $data = $request->all();
        dd($data);
        try {
            
            $user = Auth::user();

            $user->players()->create($data);

            Session::flash('message', 'O jogador foi salvo com sucesso!');
            Session::flash('color', 'green');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Session::flash('message', 'Não foi possível salvar o jogador!'); 
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        try {
            $item = Player::findorFail($id);            
        }catch(\Throwable $th){
            Session::flash('message', 'Não foi possível editar o jogador!'); 
            Session::flash('color', 'red');
            return redirect()->route('player.index');
        }
        return view('match.edit',compact('item')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlayerRequest $request, $id)
    {
        try {
            $data = $request->all(); 
            $item = Player::findorFail($id); 

            if(!empty($data['goalkeeper']) && $data['goalkeeper']=='on') {
                $data['goalkeeper'] = 1;
            }else{
                $data['goalkeeper'] = 0;
            }        

            $item->update($data);

            Session::flash('message', 'O jogador foi editado com sucesso!');
            Session::flash('color', 'green');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Session::flash('message', 'Não foi possível salvar o jogador!'); 
            Session::flash('color', 'red');
        }

	    return redirect()->route('match.index');
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
            $item = Player::findorFail($id);       
            $item->delete();     
        }catch(\Throwable $th){
            Session::flash('message', 'Não foi possível excluir o jogador!'); 
            Session::flash('color', 'red');
            return redirect()->route('player.index');
        }
        Session::flash('message', 'Jogador excluido com sucesso!'); 
        Session::flash('color', 'red');
        return redirect()->route('match.index'); 
    }
}
