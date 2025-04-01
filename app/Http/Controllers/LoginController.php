<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // @desc Show login form
    // @route GET login
    public function login(): View {
        return view('auth.login');
    }

    //@desc authenticate user
    //@route POST /login
    public function authenticate(Request $request): RedirectResponse {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:150',
            'password' => 'required|string',
        ]); 

        //attempt to authenticate user
        if(Auth::attempt($credentials)) {
            //regenerate the session to prevent fixation attacks
            $request->session()->regenerate();

            //log user in & redirect to home
            return redirect()->intended(route('home'))->with('success', 'You are now logged in');
        }
        
        //if auth fails redirect back to login screen with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records'
        ])->onlyInput('email');
    }

    // @desc logout user
    // @route POST /logout
    public function logout(Request $request): RedirectResponse {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('home');
    }

}