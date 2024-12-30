<div>
    <div>
        <form wire:submit="createItem">
            
            <div>
                <x-input-label for="name" :value="__('Nombre')" />
                <x-text-input wire:model="itemName" id="name" class="block w-full mt-1" type="text" name="name" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
    
            <div class="mt-4">
                <x-input-label for="description" :value="__('Descripción')" />
                <x-text-input wire:model="itemDescription" id="description" class="block w-full mt-1" type="text" name="description" required autocomplete="itemdescription" />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="category" :value="__('Categoría')" />
                <select wire:model="itemCategory" id="category" name="category" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">{{ __('Seleccione una categoría') }}</option>
                    <@foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
            </div>
    
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Crear') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
