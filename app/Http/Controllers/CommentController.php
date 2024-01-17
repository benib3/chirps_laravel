<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View;
     */
    public function index(Request  $request):View
    {
        //
        $comments = Comment::where('chirp_id', $request->chirp)
        ->leftJoin('users', 'comments.user_id', '=', 'users.id')
        ->select('comments.*', 'users.name as username','users.img as userimg')
        ->whereNull('comments.deleted_at')
        ->orderBy('created_at', 'desc')
        ->paginate(3);


        $chirp = Chirp::find($request->chirp);
        //echo $comments;

        return view('comments.index',[ 'chirp' => $chirp,'comments' => $comments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View;
     */
    public function create(Request  $request):View
    {
        //

        $comments = Comment::where('chirp_id', $request->chirp)
        ->leftJoin('users', 'comments.user_id', '=', 'users.id')
        ->select('comments.*', 'users.name as username')
        ->get();


        $chirp = Chirp::find($request->chirp);
        //echo $comments;

        return view('comments.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\RedirectResponse ;
     */
    public function store(Request $request):RedirectResponse
    {
        DB::beginTransaction();
        try{
            // get all request data
            $data = $request->all();
            // error log it to see what's going on
            error_log(print_r($data, true));
            error_log($request->chirp);
            // Validate the user's input...
                $request->validate([
                    'comment' => 'required|max:255',

                ]);


                Comment::create([
                    'comment' => $request->comment,
                    'user_id' => Auth::user()->id,
                    'chirp_id' => $request->chirp,
                    'created_at' => now(),
                ]);

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            error_log($e->getMessage());
        }




        return Redirect::route('chirp.comments.index', ['chirp' => $request->chirp]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\RedirectResponse ;
     */
    public function destroy(Chirp $chirp, Comment $comment) : RedirectResponse
    {
        DB::beginTransaction(); // begin the transaction
        try{

            Comment::where('id', $comment->id)->update(['deleted_at' => now()]);
            DB::commit(); // commit the transaction
        }catch(\Exception $e){
            DB::rollback(); // rollback the transaction
            error_log($e->getMessage());
        }
        return Redirect::route('chirp.comments.index', ['chirp' => $comment->chirp_id]);

    }
}
