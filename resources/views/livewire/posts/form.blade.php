<div class="bg-white rounded shadow p-5">
    <form>
        @csrf
        <div class="col-span-6 py-3">
            <x-jet-label for="header">{{ __('Title') }}</x-jet-label>
            <x-jet-input class="block mt-1 w-full" type="text" id="header" wire:model="header" name="header" autofocus />
            <x-jet-input-error for="header" class="text-red-500"></x-jet-input-error>
        </div>
        <div class="col-span-6 py-3">
            <x-jet-label for="content">{{ __('Content') }}</x-jet-label>
            <livewire:trix :value="$content" />
            <x-jet-input-error for="content" class="text-red-500"></x-jet-input-error>
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-jet-danger-button wire:click="closeModalPopover()" type="button">Close</x-jet-danger-button>
            <x-jet-button wire:click="save" wire:loading.attr="enable" type="button" class="ml-4">
                {{ __('Save') }}
            </x-jet-button>
        </div>
    </form>
</div>
