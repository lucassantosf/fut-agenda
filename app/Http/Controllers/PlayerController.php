<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\Requests\PlayerRequest;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\TeamPlayer;
use Auth;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $itens = $user->players()->paginate(20);
        return view('player.index',compact('itens')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('player.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlayerRequest $request)
    {
        try {
            $data = $request->all();
            $user = Auth::user();

            if(!empty($data['goalkeeper']) && $data['goalkeeper']=='on') {
                $data['goalkeeper'] = 1;
            }else{
                $data['goalkeeper'] = 0;
            }   

            $user->players()->create($data);

            Session::flash('message', 'O jogador foi salvo com sucesso!');
            Session::flash('color', 'green');
        } catch (\Throwable $th) {
            Session::flash('message', 'Não foi possível salvar o jogador!'); 
            Session::flash('color', 'red');
        }

	    return redirect()->route('player.index');
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
        return view('player.edit',compact('item')); 
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
            Session::flash('message', 'Não foi possível salvar o jogador!'); 
            Session::flash('color', 'red');
        }

	    return redirect()->route('player.index');
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
            
            $check = TeamPlayer::where('player_id',$item->id)->first(); 
            if(!empty($check)){
                throw new \Exception("Este jogador possui vinculo em times, exclua as partidas em que ele participou primeiro", 1);
            } 
            
            $item->delete();     
        }catch(\Throwable $th){ 
            Session::flash('message', 'Não foi possível excluir o jogador! Motivo : '.$th->getMessage()); 
            Session::flash('color', 'red');
            return redirect()->route('player.index');
        }
        Session::flash('message', 'Jogador excluido com sucesso!'); 
        Session::flash('color', 'red');
        return redirect()->route('player.index'); 
    }
}
