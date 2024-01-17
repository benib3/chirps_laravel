
<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">

        <div class="mt-6">

                <div class="p-6 flex space-x-2  bg-white  rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $chirp->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($chirp->created_at->eq($chirp->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>
                            @if ($chirp->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
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
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>
                    </div>
                </div>

        </div>
        <div class="flex justify-between items-center">
        <div class="text-2xl font-bold text-white p-2 mt-5 mb-5 underline">Comments</div>
        <!-- Modal toggle -->
        <button onclick="openModal()" data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="text-white inline-flex items-center  hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
           Leave a comment
        </button>
        </div>
        @if($comments->isEmpty())
         <div class="relative grid grid-cols-1 gap-4 mt-1 p-5 mb-4  rounded-lg justify-center text-center ">
            <div class="text-2xl font-bold text-gray-500 p-2 mt-5 mb-5 ">No Comments</div>
        </div>
        @else
            @foreach ($comments as $comment)
            <div class="relative grid grid-cols-1 gap-4 mt-1 p-5 mb-4 border rounded-lg bg-white shadow-lg">
                <div class="relative flex gap-4">
                    <img src="{{ asset('storage/images/' . $comment->userimg) }}"
                    class="relative rounded-lg -top-8 -mb-4 bg-white border h-20 w-20" alt="Profile Img" loading="lazy">
                    <div class="flex flex-col w-full">
                    @if ($comment->user->is(auth()->user()))
                        <div class="absolute top-0 right-0 ">
                           <form method="POST" action="{{ route('chirp.comments.destroy', ['chirp'=> $chirp,'comment'=> $comment]) }}" class="">
                            @csrf
                            @method('delete')
                            <a class="flex space-x-2 gap-2 justify-content-center text-center align-center hover:text-red-500" href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none"  viewBox="0 0 24 24">
                                    <path d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z"/>
                                </svg>
                                {{ __('Delete') }}
                            </a>
                            </form>
                        </div>
                    @endif
                        <div class="flex flex-row justify-between">
                            <p class="relative text-xl whitespace-nowrap truncate overflow-hidden">{{$comment -> username}}</p>
                            <a class="text-gray-500 text-xl" href="#"><i class="fa-solid fa-trash"></i></a>
                        </div>
                        <p class="text-gray-400 text-sm">{{ $comment->created_at->format('j M Y, g:i a')  }}</p>
                    </div>
                </div>

                <p class="mt-2 ml-2 text-gray-500">{{ $comment->comment }}</p>

            </div>
            @endforeach
        @endif
        <div class="mt-1">
            {{ $comments->links()}}
        </div>
    </div>

@include('comments.create')
</x-app-layout>
