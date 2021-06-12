<x-app-layout>
    <x-slot name="header">
        <div class="header-form">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Partidas') }}
            </h2> 
            <a href="{{route('match.index')}}" class="bg-info border border-transparent rounded-md inline-flex items-center px-4 py-1" >
                {{ __('Voltar') }}
            </a> 
        </div>
    </x-slot>

    @include('components.error_messages') 

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{route('match.store')}}" method="POST" id="sort-teams-form">
                        @csrf

                        <div>
                            <x-label for="name" :value="__('Descrição da partida')" /> 
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="number" :value="__('Número de jogadores por time')" /> 
                            <x-input id="number" class="block mt-1 w-full" type="number" name="number" />
                        </div>
 
                        <x-label for="goalkeeper" :value="__('Selecione todos jogadores que marcaram presença')" /> 
                        
                        <div style="players-pick">
                            @foreach($players as $player)
                            <div class="mt-1"> 
                                <input type="checkbox" class="form-control rounded-md border-gray-300" name="players[]" value="{{$player->id}}"/>{{$player->name}} - Posição : {{$player->goalkeeper == '1' ? 'Goleiro' : 'Linha'}}
                            </div> 
                            @endforeach
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="button" class="focus:outline-none openModal text-white text-sm py-2.5 px-5 mt-5 mx-5  rounded-md bg-green-500 hover:bg-green-600 hover:shadow-lg">Open Modal</button>
                            <x-button id="sort-teams">
                                {{ __('Sortear') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="fixed z-10 inset-0 invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="interestModal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start"> 
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                  Veja a previsualização dos times
                                </h3>
                            <div class="mt-2" id="feedback">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Salvar
                    </button>
                    <button type="button" class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('ready',function(){

            $('.openModal').on('click', function(e){
                $('#interestModal').removeClass('invisible');
            });

            $('.closeModal').on('click', function(e){
                $('#interestModal').addClass('invisible');
            });
             
            $("#sort-teams").on('click',(e)=>{
                
                e.preventDefault(); 

                $.ajax("{{route('sort_teams')}}", {
                    type: "POST",
                    data: $("#sort-teams-form").serialize(),
                    success: response => {
                        
                        html = response      
                        console.log(response)
                        console.log(response.data)
                        console.log(html)

                        $("#feedback").html(html);
                        $('#interestModal').removeClass('invisible');

                    },
                    error: (response,status) => {
                        console.log(status)
                        console.log(response)
                        console.log(response.responseJSON)
                        console.log(response.responseJSON.errors)
                        const temp = response.responseJSON.errors;
                        const messages = Object.keys(temp).map(key => temp[key]);
                        html = '<div class="alert alert-danger">';

                        messages.map(msg => {
                            html += `${msg} <br/>`;
                        });
                        html += "</div>";

                        $("#feedback").html(html);
                        $('#interestModal').removeClass('invisible');
                    }
                });

            })

        })

    </script>
    
</x-app-layout>
