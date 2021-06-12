<x-app-layout>
    <x-slot name="header">
        <div class="header-form">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Partidas') }}
            </h2>
            <a href="{{route('match.create')}}" class="bg-info border border-transparent rounded-md inline-flex items-center px-4 py-1" >
                {{ __('Adicionar') }}
            </a> 
        </div>
    </x-slot>

    @include('components.alert_messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-table>
                        <x-slot name="header">
                            <x-table-column>Descrição</x-table-column>
                            <x-table-column>Data</x-table-column>
                            <x-table-column>Ações</x-table-column>
                        </x-slot> 
                        @if(!empty($itens))
                            @foreach($itens as $item)
                                <tr>
                                    <x-table-column>{{$item->name}}</x-table-column>
                                    <x-table-column>{{$item->crated_at}}</x-table-column>
                                    <x-table-column>
                                        <form action="{{route('match.destroy', $item->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE"/>

                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                   
                                                <x-button class="bg-red">
                                                    {{ __('Deletar') }}
                                                </x-button>

                                            </div>
                                        </form> 
                                    </x-table-column>
                                </tr> 
                            @endforeach
                        @endif
                    </x-table>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
