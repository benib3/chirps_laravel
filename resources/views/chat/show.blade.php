<x-app-layout>

    <x-slot name="header" class="bg:dark-900">
        <h2 class="font-semibold text-xl text-white">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="container mx-auto justify-center items-center">
        @include('chat.partials.chat')
    </div>

</x-app-layout>
