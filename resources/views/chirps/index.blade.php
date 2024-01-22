<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('chirps.store') }}">
            @csrf
            <textarea
                name="message"
                placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border-gray-300 focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Chirp') }}</x-primary-button>
        </form>

    @if ($chirps->isEmpty())
        <div class="mt-6">
                <p class="mt-4 text-lg text-gray-400">{{ __('There are no chirps yet.') }}</p>
        </div>
    @else

        <div class="mt-6">
            @foreach ($chirps as $chirp)

                <div class="p-6 flex space-x-2  bg-white rounded-lg shadow-sm dark:shadow-gray-400 ">
                    <img src=" {{ asset('storage/images/' . $chirp->user->img) }} " alt="image" class="mr-2 rounded-lg w-20 h-20 object-cover">
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div class="mt-1">
                                <span class="text-gray-800">{{ $chirp->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($chirp->created_at->eq($chirp->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">

                                       <x-dropdown-link class="cursor-pointer" @click.prevent="openModal">
                                            {{ __('Comment') }}
                                        </x-dropdown-link>
                                        @if ($chirp->user->is(auth()->user()))
                                        <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                          @endif
                                    </x-slot>
                                </x-dropdown>

                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>
                    </div>
                </div>

                <div class="flex justify-end p-2 mb-2 rounded-lg gap-2">


                    <a href=" {{route('chirp.comments.index', ['chirp' => $chirp->id])}} ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer h-6 w-6 text-white -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </a>

                    {{-- Comments counter --}}
                    <span class="mr-1 text-white">{{$chirp->comments_count}}</span>

                    @include('chirps.partials.form-likes')

                    {{-- Likes counter --}}
                    <span class="mr-1 text-white">{{$chirp->likes_count}}</span>
                </div>
            @endforeach

        </div>

        <div class="mt-1">
            {{ $chirps->links()}}
        </div>
    </div>
    @include('comments.create')

    @endif
</x-app-layout>

<script>
    // When the page is loaded
        window.onload = function() {
            // If there's a scroll position in sessionStorage, scroll to it
            if (sessionStorage.scrollPosition) {
                window.scrollTo(0, sessionStorage.scrollPosition);
            }
        }

        // Before the page is unloaded (refreshed)
        window.onbeforeunload = function() {
            // Store the current scroll position in sessionStorage
            sessionStorage.scrollPosition = window.scrollY || document.documentElement.scrollTop;
        }
</script>
