@if (session('message')) 

    <div class="bg-{{ session('color') }}-100 border-t border-b border-{{ session('color') }}-500 text-{{ session('color') }}-700 px-4 py-3" role="alert">
        <p class="font-bold">{{ session('message') }}</p> 
    </div>

@endif 