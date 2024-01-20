
{{-- chat blade partial --}}

<div class="flex flex-col bg-gray-100 rounded-lg mx-8">

    <div class="bg-red-700 py-4 rounded-tl rounded-tr">
        <h1 class="text-center text-2xl font-bold text-white">{{$chat_user->name}}</h1>
    </div>

    <div class="flex-grow overflow-y-auto">
        <!-- Chat messages -->
        <div class="flex flex-col space-y-2 p-4">
        <!-- Individual chat message -->
        <div class="flex items-center self-end rounded-xl rounded-tr bg-red-500 py-2 px-3 text-white">
            <p>This is a sender message</p>
        </div>
        <div class="flex items-center self-start rounded-xl rounded-tl bg-gray-300 py-2 px-3">
            <p>This is a receiver message</p>
        </div>
        </div>

    </div>


    <div class="flex items-center p-4">
        <input type="text" placeholder="Type your message..." class="w-full rounded-lg border border-gray-300 px-4 py-2" />
        <button class="ml-2 rounded-lg bg-red-500 px-4 py-2 text-white">Send</button>
    </div>

</div>