<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //@desc update profile info
    //@route PUT /profile

    public function update(Request $request): RedirectResponse {
        //get logged in user
        $user = Auth::user();

        //validate data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        //get user name and email
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        //handle avatar upload
        if($request->hasFile('avatar')) {
            //delete the old avatar if it exists
            if($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            //store the new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
        /** @disregard P1013 */
        $user->save();
        
        return redirect()->route('dashboard')->with('success', 'Your profile has been updated!');
    }
}