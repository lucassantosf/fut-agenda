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
                                    <x-table-column>{{$item->dataBR}}</x-table-column>
                                    <x-table-column>
                                        <form action="{{route('match.destroy', $item->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE"/>

                                            <div class="btn-group" role="group" aria-label="Basic example">

                                                <a onclick="show({{$item->id}})" class="bg-info border border-transparent rounded-md inline-flex items-center px-4 py-1">
                                                    {{ __('Ver') }}
                                                </a>

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

            {{$itens->appends(Request::except('_token'))->links()}}

        </div>
    </div>

    <!-- Modal Feedback -->
    <div class="fixed z-10 inset-0 invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="interestModal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start"> 
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Veja os times da partida
                                </h3>
                            <div class="mt-2" id="feedback">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"> 
                    <button type="button" class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Feedback -->

    <script type="text/javascript">
        function show(id){  
            var token =  $('input[name="_token"]').attr('value')
            
            $.ajax('{{route("match.show.table")}}', {
                type: "POST", 
                headers:{
                    'X-CSRF-Token': token 
                },
                data:{
                    id
                },
                success: response => { 
                    html = response       

                    $("#feedback").html(html); 
                    $('#interestModal').removeClass('invisible');
                    
                },
                error: (response,status) => {
                        
                    $("#btn-send").attr("disabled", true); 
                    const error = response.responseJSON

                    try {
                        const temp = response.responseJSON.errors
                        const messages = Object.keys(temp).map(key => temp[key])
                        
                        html = ''
                        messages.map(msg => {
                            html += `${msg} <br/>`
                        });

                    } catch (error) {
                        html = response.responseJSON 
                    }

                    $("#feedback").html(html)
                    $("#modal-title").html('Oppss !')
                }
            });

        }

        $(document).on('ready',function(){

            $('.closeModal').on('click', function(e){
                $('#interestModal').addClass('invisible');
            });             

        })
 
    </script>
    
</x-app-layout>
