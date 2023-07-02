<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="pt-12 pb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-3 max-sm:mr-2">
                <x-jet-button wire:click="openModalPopover()">
                    Posting
                </x-jet-button>
            </div>
            @if ($isModalOpen)
                @include('livewire.posts.form')
            @endif
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
            @foreach ($posts as $post)
                <div class="bg-white sm:rounded-lg p-5 sm:p-6 my-4">
                    <div class="text-lg font-bold text-gray-900 flex justify-start">
                        <div class="mr-3">
                            <img class="h-10 w-10 rounded-full object-cover"
                                src="{{ $post->user->profile_photo_url }}"
                                alt="{{ $post->user->name }}" />
                        </div>
                        <div class="align-middle capitalize pt-2">
                            {{ $post->header }}
                        </div>
                    </div>

                    <div class="mt-2 text-xs text-gray-400 ml-4 flex justify-between">
                        <div>
                            {{ $post->user->name }}
                        </div>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-5">
                        <div class="px-4 py-5 sm:p-6 sm:rounded-lg trix-editor">
                            {!! $post->content !!}
                        </div>
                    </div>
                    <div class="flex justify-end">
                        @if (Auth::user()->role == 'admin' || Auth::user()->id == $post->user->id)
                            <x-jet-secondary-button onclick="confirm({{ $post->id }})"
                                class="border-none shadow-none px-3 openModal">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-800">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </x-jet-secondary-button>
                        @endif
                        @if (Auth::user()->id == $post->user->id)
                            <x-jet-secondary-button class="border-none shadow-none px-3" onclick="goToTop()"
                                wire:click="edit({{ $post->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </x-jet-secondary-button>
                        @endif
                    </div>
                    <div class="text-gray-400 flex justify-end">
                        @if ($post->updated_at != $post->created_at)
                            <div class="text-xs text-blue-300">
                                Edit {{ $post->updated_at }}
                            </div>
                        @endif
                        <div class="text-xs ml-5">
                            Post {{ $post->created_at }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @include('button-confirm')
        <footer>
            <button id="to-top-button" onclick="goToTop()" title="Go To Top"
                class="hidden fixed z-90 bottom-8 right-8 border-0 w-16 h-16 rounded-full drop-shadow-md bg-gray-500 text-white text-3xl font-bold">&#8679;</button>
            <div class="text-center">
                @if ($posts->hasMorePages())
                    <button id="load-more" class="text-blue-400 mt-3">
                        Load More
                    </button>
                @endif
            </div>
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            var userId = null;
            var buttonConfirm = document.getElementById("interestModal");
            var toTopButton = document.getElementById("to-top-button");
            var loadMore = document.getElementById("load-more");

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

            if (loadMore) {
                loadMore.onclick = function() {
                    window.livewire.emit('post-data');
                };
            };
            // When the user scrolls down 200px from the top of the document, show the button
            window.onscroll = function() {
                if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                    toTopButton.classList.remove("hidden");
                } else {
                    toTopButton.classList.add("hidden");
                }
            }
            // When the user clicks on the button, scroll to the top of the document
            function goToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        </script>
    </div>
</div>
