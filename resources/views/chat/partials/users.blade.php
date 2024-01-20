<x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-500 hover:text-white focus:outline-none transition ease-in-out duration-150">
                    {{-- User selected --}}
                    <div>List of users</div>
                    <div class="ml-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                {{-- users list --}}
                {{-- for each user connected to logged user display name --}}
                    @foreach ($users as $user)
                        <x-dropdown-link :href="route('chirps.chat.show',['user' => $user->id]) ">
                                {{ $user->name}}
                        </x-dropdown-link>
                    @endforeach

            </x-slot>
</x-dropdown>



