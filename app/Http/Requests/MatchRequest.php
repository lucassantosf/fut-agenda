<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'number'=>'required|min:1', 
            'players'=>'required|min:1',
        ];
    }

    public function messages(){
        return [
            'name.required'=>'Descrição da partida é obrigatório',
            'number.required'=>'Número de jogadores por time é obrigatório',
            'number.min'=>'Número de jogadores por time é minimo de 1',
            'players.required'=>'A lista de jogadores presentes é obrigatório', 
            'players.min'=>'A quantidade mínima de jogadores confirmados é 1',
        ];
    }
}
