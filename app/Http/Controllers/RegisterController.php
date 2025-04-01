<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //@desc show register form
    //@route GET /register
    public function register(): View {
        return view('auth.register');
    }

    //@desc store user in database
    //@route POST /register
    public function store(Request $request): RedirectResponse {
        $validatedData = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]); 

        //hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        //create user
        $user = User::create($validatedData);

        return redirect()->route('login')->with('success', 'You are now registered and can login.');
    }
}