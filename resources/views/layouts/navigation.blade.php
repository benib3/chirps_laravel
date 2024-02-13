<script>
const socket = io('http://localhost:3000');
socket.on('connect', () => {
    console.log('connected');

    socket.emit('user_conected', {{ Auth::user()->id }});
    socket.on('the_user', (data) => {
      // Step 1: Retrieve existing value from the div
      let existingValue = parseInt(document.getElementById('notify').innerHTML);

      // Step 2: Add new value to it
      let result = existingValue + data;

      // Step 3: Update the div content with the result
      document.getElementById('notify').innerHTML = result;

    })
});


</script>


<nav x-data="{ open: false }" class="border-b dark:bg-gray-900 border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-red-500" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex ">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-red-500">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex ">
                <x-nav-link :href="route('chirps.index')" :active="request()->routeIs('chirps.index')" class="text-red-400">
                        {{ __('Chirps') }}
                </x-nav-link>
                <x-nav-link  :href="route('chirps.chat.index')" :active="request()->routeIs('chirps.chat.index')" class="text-red-400">
                    {{ __('Chat') }}
                </x-nav-link >
             </div>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 ">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-500 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                             @if( Auth::user()->img)
                                <img src=" {{ asset('storage/images/' .  Auth::user()->img) }} " alt="image" class="object-cover w-10 h-10 rounded-full ring-2 ring-gray-300 ml-2">
                            @else
                                <img src=" https://images.unsplash.com/photo-1615012553971-f7251c225e01?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D " alt="image" class="object-cover w-10 h-10 rounded-full ring-2 ring-gray-300 ml-2">
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->

                <div class="relative">
                    <svg class="w-8 h-8 text-red-600 animate-wiggle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 21"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M15.585 15.5H5.415A1.65 1.65 0 0 1 4 13a10.526 10.526 0 0 0 1.5-5.415V6.5a4 4 0 0 1 4-4h2a4 4 0 0 1 4 4v1.085c0 1.907.518 3.78 1.5 5.415a1.65 1.65 0 0 1-1.415 2.5zm1.915-11c-.267-.934-.6-1.6-1-2s-1.066-.733-2-1m-10.912 3c.209-.934.512-1.6.912-2s1.096-.733 2.088-1M13 17c-.667 1-1.5 1.5-2.5 1.5S8.667 18 8 17"/></svg>
                    <div id="notify" class="px-1 bg-red-500 rounded-full text-center text-white text-sm absolute -top-3 -end-2">
                        {{ Auth::user()->unreadNotifications->count() }}
                        <div class="absolute top-0 start-0 rounded-full -z-10 animate-ping bg-teal-200 w-full h-full" ></div>
                    </div>
                </div>
            </div>



            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
            <x-responsive-nav-link :href="route('chirps.index')" :active="request()->routeIs('chirps.index')">
                {{ __('Chirps') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('chirps.chat.index')" :active="request()->routeIs('chirps.chat.index')">
                {{ __('Chat') }}
            </x-responsive-nav-link>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 h-screen">
            <div class="px-4">
                <div class="font-medium text-base text-gray-600">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
