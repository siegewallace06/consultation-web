<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="md:max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (Auth::user()->role == 'admin')
                <div class="flex justify-end mb-3 max-sm:mr-2">
                    <x-jet-button wire:click="create()">
                        Create user
                    </x-jet-button>
                </div>
                @if ($isModalOpen)
                    @include('livewire.users.form')
                @endif
            @endif
            <div class="col-span-6 max-sm:mx-2">
                <x-jet-label for="search" value="{{ __('Search') }}" />
                <x-jet-input id="search" class="rounded-lg mt-1 w-full" type="text" wire:model="search"
                    placeholder="Search" />
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5 px-4 py-4">
                @if (session()->has('message'))
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                        role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="overflow-x-auto relative mt-4">
                    <table class="w-full text-sm text-left text-gray-500 max-sm:flex flex-row flex-no-wrap">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 max-sm:hidden">
                            <tr class="max-sm:flex sm:table-row flex-col flex-none wrap sm:mb-0">
                                <th scope="col" class="px-4 py-3">Nomor Induk</th>
                                <th scope="col" class="px-4 py-3">Name</th>
                                <th scope="col" class="px-4 py-3">Email</th>
                                <th scope="col" class="px-4 py-3">Role</th>
                                @if (Auth::user()->role == 'admin')
                                    <th scope="col" class="px-4 py-3">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="max-sm:flex-1 sm:flex-none">
                            @foreach ($users as $user)
                                <tr class="bg-white border-b max-sm:flex flex-col flex-no wrap sm:table-row ">
                                    <td scope="row" class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $user['id'] }}</td>
                                    <td scope="row" class="px-4 py-2 capitalize">{{ $user->name }}</td>
                                    <td scope="row" class="px-4 py-2">{{ $user->email }}</td>
                                    <td scope="row" class="px-4 py-4">
                                        <label
                                            class="p-2 text-sm {{ $user->role == 'admin' ? 'bg-gray-100' : ($user->role == 'konselor' ? ' bg-blue-100' : 'bg-red-100') }} rounded-xl capitalize">{{ $user->role }}
                                        </label>
                                    </td>
                                    @if (Auth::user()->role == 'admin')
                                        <td scope="row" class="px-4 py-2 mb-2">
                                            <x-jet-button wire:click="edit({{ $user->id }})">Edit</x-jet-button>
                                            <x-jet-danger-button onclick="confirm({{ $user->id }})">
                                                Delete
                                            </x-jet-danger-button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('button-confirm')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        var user_id;
        var buttonConfirm = document.getElementById("interestModal");

        function confirm(id) {
            userId = id;
            buttonConfirm.classList.remove('hidden');
        }
        $('.confirm').on('click', function() {
            @this.call('delete', userId);
            buttonConfirm.classList.add('hidden');
        });

        $('.closeModal').on('click', function() {
            buttonConfirm.classList.add('hidden');
        });
    </script>
</div>
