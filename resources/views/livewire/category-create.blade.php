<div>
    <div>
        <form wire:submit="createCategory">
            
            <div>
                <x-input-label for="name" :value="__('Nombre')" />
                <x-text-input wire:model="categoryName" id="name" class="block w-full mt-1" type="text" name="name" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
    
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Crear') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
