<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
class ChatController extends Controller
{
    //
    public function index(Request  $request):View
    {
        //return list of users that can chat with auth user with view
        //Auth user can only chat with users who commented on some of his chirps

        //get all chirps of auth user
            $chirps = Chirp::where('user_id', Auth::user()->id)
                        ->with(['comments' => function($query){
                            $query->select('chirp_id','user_id');
                            $query->whereNull('deleted_at');
                            $query->where('user_id', '!=', Auth::user()->id);
                            $query->with(['user' => function($query){
                                $query->select('id','name');

                            }]);
                        }])

                        ->get();

            // Get user IDs from comments on chirps
            $userIds = [];
            foreach ($chirps as $chirp) {
                foreach ($chirp->comments as $comment) {
                    $userIds[] = $comment->user;
                }
            }

            // Remove duplicates
            $userIds = array_unique($userIds);

        return view('chat.index', ['users' => $userIds]);
    }


    public function show (Request $request):View
    {
        //return view of chat with user
        $user = $request->user;
        $chat_user = User::find($user);

        return view('chat.show', ['chat_user' => $chat_user]);
    }
}
