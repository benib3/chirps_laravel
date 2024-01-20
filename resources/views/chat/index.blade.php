<x-app-layout>

<x-slot name="header" class="bg:dark-900">
    <h2 class="font-semibold text-xl text-white">
        {{ __('Chat') }}
    </h2>
</x-slot>


<!-- container for chat and list of users -->
<div class="container mx-auto justify-center items-center">
        <div class="hidden sm:flex sm:items-center sm:ml-6 ">
            @includeFirst(['chat.partials.users']);
        </div>
</div>

</x-app-layout>
