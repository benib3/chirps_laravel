<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View;
     */
    public function index():View
    {
        // chirps with comments and likes
        // also if user already liked chirp or not
        return view('chirps.index', [
            'chirps' => Chirp::with('user')
                        ->withCount(['comments' => function ($query) {
                            $query->whereNull('deleted_at');
                        }])
                        ->withCount('likes')
                        ->with(['likes' => function($query) {
                            $query->where('user_id', Auth::id())
                                  ->select('chirp_id');
                        }])
                        ->latest()
                        ->paginate(5),
        ]);
    }

        //


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) :RedirectResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'max:255'],
        ]);

        $request->user()->chirps()->create($validated);

        return Redirect::route('chirps.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function edit(Chirp $chirp):View
    {
        $this->authorize('update', $chirp);

        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chirp $chirp):RedirectResponse
    {
        //
        $this->authorize('update', $chirp);
        $validated = $request->validate([
            'message' => ['required', 'max:255'],
        ]);

        $chirp->update($validated);

        return Redirect::route('chirps.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chirp $chirp):RedirectResponse
    {
        //
        $this->authorize('delete', $chirp);
        $chirp->delete();

        return Redirect::route('chirps.index');
    }

}
