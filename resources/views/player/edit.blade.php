<x-app-layout>
    <x-slot name="header">
        <div class="header-form">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jogadores') }}
            </h2>
            <a href="{{route('player.index')}}" class="bg-info border border-transparent rounded-md inline-flex items-center px-4 py-1" >
                {{ __('Voltar') }}
            </a>
        </div>
    </x-slot>

    @include('components.error_messages') 

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{route('player.update',$item->id)}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" />

                        <div>
                            <x-label for="name" :value="__('Nome')" /> 
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name',$item->name)" autofocus />
                        </div>
 
                        <div class="mt-4">
                            <x-label for="goalkeeper" :value="__('Goleiro?')" /> 
                            <input type="checkbox" @if(old('goalkeeper',$item->goalkeeper) == 'on') checked @endif  class="form-control rounded-md border-gray-300" name="goalkeeper"/>
                        </div>

                        <div class="mt-4">
                            <x-label for="password" :value="__('Habilidade')" /> 
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="level">
                                <option value=""  @if(old('level') == '') selected @endif>Selecione um nível</option>
                                <option value="1" @if(old('level',$item->level) == 1) selected @endif>1-Pereba</option>
                                <option value="2" @if(old('level',$item->level) == 2) selected @endif>2-Serve para completar time</option>
                                <option value="3" @if(old('level',$item->level) == 3) selected @endif>3-Até que não é ruim</option>
                                <option value="4" @if(old('level',$item->level) == 4) selected @endif>4-Café com leite</option>
                                <option value="5" @if(old('level',$item->level) == 5) selected @endif>5-Pró</option>
                            </select>
                        </div>

                        <div class="flex justify-end mt-4">
                            <x-button>
                                {{ __('Salvar') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
