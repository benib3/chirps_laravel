<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Chirp;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
class ChatController extends Controller
{


    public function index(Request  $request):View
    {
        //get all users
        $users = User::where('id', '!=', Auth::id())->paginate(5);

        return view('chat.index', ['users' => $users]);
    }


    public function show (Request $request):View
    {
        //return view of chat with user
        $user = $request->user;
        $chat_user = User::find($user);

        $messages_sent = Chat::where('from_id', Auth::user()->id)
            ->where('to_id', $user)
            ->select('text','created_at','from_id') // Only select the 'text' column
            ->get();

        $messages_received = Chat::where('from_id', $user)
            ->where('to_id', Auth::user()->id)
            ->select('text','created_at') // Only select the 'text' column
            ->get();


        return view('chat.show', ['chat_user' => $chat_user, 'messages_sent' => $messages_sent, 'messages_received' => $messages_received]);
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
                'text' => ['required', 'max:255'],
            ]);
            $message = new Chat;
            $message->from_id = Auth::id();
            $message->to_id = $request->user;
            $message->text = $request->input('text');
            $message->is_read = true;
            $message->save();

            //Create notification for the user that received the message
            $notification = new Notifications;
            $notification->insert(Auth::id(), $request->user ,'chat' ,'You have a new message');




            return back();
    }

}
