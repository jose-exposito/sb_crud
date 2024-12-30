<div>
    <div x-data="{ edit: false }">

        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                class="p-4 mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded">
                {{ session('message') }}
            </div>
        @endif
    
        {{-- <div class="mb-4">
            <x-input-label for="search" :value="__('Buscar Elementos')" />
            <x-text-input wire:model="search" id="search" class="block w-full mt-1" type="text" placeholder="Buscar por nombre..." />
        </div> --}}
    
        <div class="overflow-hidden border border-gray-200 rounded-lg shadow-md">
            
            <table class="w-full text-left table-auto" style="text-align: center">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Descripción</th>
                        <th class="px-4 py-2">Categoría</th>
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $item->id }}</td>
                            <td class="px-4 py-2">{{ $item->name }}</td>
                            <td class="px-4 py-2">{{ $item->description }}</td>
                            <td class="px-4 py-2">{{ $item->category->name }}</td>
                            <td class="px-4 py-2">{{ $item->image }}</td>
                            <td class="px-4 py-2">
                                <button @click="edit = true" wire:click="selectItem({{ $item->id }})" class="text-blue-500 hover:underline">Editar</button>
                                <button wire:click="delete({{ $item->id }})" class="text-red-500 hover:underline">Eliminar</button>
                            </td>
                        </tr>

                        <div 
                                x-show="edit" 
                                x-transition 
                                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500 bg-opacity-50 backdrop-blur-md">

                                <div class="max-w-lg mx-auto overflow-hidden transition-all transform bg-white rounded-lg shadow-lg sm:w-3/4 lg:w-1/3">
                                    <div class="p-6">

                                        <div class="flex items-center justify-between mb-4">
                                            <h2 class="text-xl font-semibold text-gray-800">Editar Categoría</h2>
                                            <button @click="edit = false" class="text-gray-500 hover:text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <form wire:submit="editItem({{ $item->id }})" class="space-y-4">

                                            <div>
                                                <label for="selectedItemName" class="block text-sm font-medium text-gray-600">Nombre del elemento</label>
                                                <input type="text" wire:model="selectedItemName" id="selectedItemName" class="block w-full px-4 py-2 mt-2 text-gray-800 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>

                                            <div>
                                                <label for="selectedItemDescription" class="block text-sm font-medium text-gray-600">Descripción del elemento</label>
                                                <input type="text" wire:model="selectedItemDescription" id="selectedItemDescription" class="block w-full px-4 py-2 mt-2 text-gray-800 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>

                                            <div>
                                                <label for="selectedItemCategory" class="block text-sm font-medium text-gray-600">Categoría</label>
                                                <select wire:model="selectedItemCategory" id="selectedItemCategory" name="selectedItemCategory" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="">{{ __('Seleccione una categoría') }}</option>
                                                    <@foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <label for="selectedItemImage" class="block text-sm font-medium text-gray-600">Imagen del elemento</label>
                                                <input type="text" wire:model="selectedItemImage" id="selectedItemImage" class="block w-full px-4 py-2 mt-2 text-gray-800 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>

                                            <div class="flex justify-end gap-4 mt-6">
                                                <button type="submit" @click="edit = false" class="px-6 py-2 text-black bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    Confirmar
                                                </button>
                                                <button type="button" @click="edit = false" class="px-6 py-2 text-white bg-red-600 rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">No se encontraron categorías.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

         {{--    <div class="mt-4">
                {{ $items->links() }}
            </div> --}}

        </div>

        <div class="mt-4">
            <button wire:click="generateCSV" class="px-6 py-2 text-black bg-green-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Exportar a CSV
            </button>
        </div>
    
</div>
