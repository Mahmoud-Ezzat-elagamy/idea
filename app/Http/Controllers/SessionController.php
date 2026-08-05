<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($validatedData)) {
            return back()
                ->withErrors(['password' => 'We were unable to authenticate using the provided credentials.'])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended('/')->with('success', 'You are now logged in!');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/login');
    }
}
