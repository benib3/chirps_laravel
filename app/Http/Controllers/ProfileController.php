<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // check if profile image is uploaded
        if ($request->hasFile('profileImage')) {

            //TODO i need to delete the old image
            //check if image exists in db
            if ($request->user()->img) {
                //delete the old image
                try {
                    unlink(storage_path('app/public/images/' . $request->user()->img));
                } catch (\Exception $e) {
                    dd($e);
                }
            }


            $image = $request->file('profileImage');
            $hash = Hash::make($request->user()->id);
            $img_name = 'profile_' . $hash. '.' . $request->file('profileImage')->extension();
            //save the image
            $image->storeAs('public/images', $img_name);

            //update the user's image
            try {
                User::where('id', $request->user()->id)->update(['img' => $img_name]);
            } catch (\Exception $e) {
                dd($e);
            }
        }
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
