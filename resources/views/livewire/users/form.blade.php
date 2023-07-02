<x-jet-form-section submit="users">
    <div class="col-span-2">

        <x-slot name="title">{{ __('Users') }}</x-slot>
        <x-slot name="description">{{ __('Update/Created') }}</x-slot>
    </div>
    <x-slot name="form">
        @csrf
        <div class="col-span-6">
            <x-jet-label for="user_id" value="{{ __('Nomor Induk') }}" />
            <x-jet-input id="user_id" class="block mt-1 w-full {{ $isDisabled ? 'bg-gray-200 text-gray-500' : '' }}"
                disabled="{{ $isDisabled }}" type="text" wire:model="user_id" required autofocus
                autocomplete="Nomor Induk" />
            <x-jet-input-error for="user_id" class="text-red-500"></x-jet-input-error>
        </div>
        <div class="col-span-6">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model="name" required autofocus
                autocomplete="name" />
            <x-jet-input-error for="name" class="text-red-500"></x-jet-input-error>
        </div>

        <div class="col-span-6">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" class="block mt-1 w-full" type="email" wire:model="email" required
                autofocus />
            <x-jet-input-error for="email" class="text-red-500"></x-jet-input-error>
        </div>
        <div class="col-span-6 form-textarea border-none px-0">
            <x-jet-label for="role" value="{{ __('Role') }}" />
            <select class="rounded-lg block w-full border-gray-300" id="role" wire:model="role" required autofocus>
                <option selected value="">-</option>
                <option value="admin">Admin</option>
                <option value="konselor">Konselor</option>
                <option value="mahasiswa">Mahasiswa</option>
            </select>
            <x-jet-input-error for="role" class="text-red-500"></x-jet-input-error>
        </div>
        <div class="col-span-6">
            <x-jet-label for="password" value="{{ __('Password') }}" />
            <x-jet-input id="password" class="block mt-1 w-full" type="password" wire:model="password" required
                autocomplete="new-password" />
            <x-jet-input-error for="password" class="text-red-500"></x-jet-input-error>
        </div>

        <div class="col-span-6">
            <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password"
                wire:model="password_confirmation" required autocomplete="new-password" />
            <x-jet-input-error for="password_confirmation" class="text-red-500"></x-jet-input-error>
        </div>


        <x-slot name="actions" class="flex items-center justify-end ">
            <x-jet-danger-button wire:click="closeModalPopover()" type="button">Close
            </x-jet-danger-button>
            <x-jet-button wire:click.prevent="store()" wire:loading.attr="enable" type="button" class="ml-4">
                {{ __('Done') }}
            </x-jet-button>
        </x-slot>
    </x-slot>
</x-jet-form-section>
