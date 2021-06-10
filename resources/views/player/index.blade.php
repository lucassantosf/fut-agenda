<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-table>
                        <x-slot name="header">
                            <x-table-column>Name</x-table-column>
                            <x-table-column>SKU</x-table-column>
                            <x-table-column>Category</x-table-column>
                            <x-table-column>Status</x-table-column>
                        </x-slot> 
                        <tr>
                            <x-table-column>product->name</x-table-column>
                            <x-table-column>product->sku</x-table-column>
                            <x-table-column>product->category</x-table-column>
                            <x-table-column>product->status</x-table-column>
                        </tr> 
                    </x-table>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
