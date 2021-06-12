<table>
    @if(!empty($itens))
        @foreach($itens as $item) 
            <tr>
                <td>Time</td>
            </tr>
            @foreach($item as $obj)  
            <tr>
                <td>{{$obj->name}}</td>
            </tr>
            @endforeach
        @endforeach
    @endif
</table>