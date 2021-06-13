<table>
    @if(!empty($teams)) 
        @foreach($teams as $team) 
            <tr>
                <td>Time</td>
            </tr>
            @foreach($team->players as $obj)  
            <tr>
                <td>{{$obj->player->name}}</td>
            </tr>
            @endforeach
        @endforeach
    @endif
</table>