
{{-- chat blade partial --}}

<div class="flex flex-col bg-gray-100 rounded-lg mx-8 ">

    <div class="bg-red-700 py-4 rounded-tl rounded-tr">
        <h1 class="text-center text-2xl font-bold text-white">{{$chat_user->name}}</h1>
    </div>



    <div class="flex-grow overflow-y-auto">
        <!-- Chat messages -->
        <div class="flex flex-col space-y-2 p-4 overflow-y-auto">

            {{-- Merge and sort the messages --}}
            @php
                $messages = $messages_sent->concat($messages_received)->sortBy('created_at');
            @endphp

            @foreach ($messages as $message)
                @if ($message->from_id == Auth::user()->id)
                    {{-- Message sent --}}
                    <div class="flex items-center self-end ">
                        <div class="flex flex-col">
                            <p class="bg-red-500 py-2 px-3 text-white rounded-xl rounded-tr ">{{ $message->text }}</p>
                            <span class="text-gray-400 self-end"> {{ $message->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @else
                    {{-- Message received --}}
                    <div class="flex items-center self-start ">
                        <div class="flex flex-col">
                            <p class="rounded-xl rounded-tl bg-gray-300 py-2 px-3 ">{{ $message->text }}</p>
                            <span class="text-gray-400"> {{ $message->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endif
            @endforeach


        </div>
    </div>

    <!-- Chat send -->
    <form method="POST" action="{{ route('chirps.chat.store', ['user' => $chat_user -> id]) }}">
        @csrf
        <div class="flex items-center p-4">
            <input type="text" name="text" placeholder="Type your message..." class="w-full rounded-lg border border-gray-300 px-4 py-2" />
            <button type="submit" class="ml-2 rounded-lg bg-red-500 px-4 py-2 text-white">Send</button>
        </div>
    </form>

</div>
