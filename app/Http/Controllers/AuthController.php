<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validate

        $fields = $request->validate(
            rules: [
                'avatar' => ['file', 'image', 'max:2000', 'nullable'],
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed'],
            ],
        );

        $fields['password'] = bcrypt($fields['password']);

        $fields['avatar'] = $request->hasFile('avatar') ? Storage::disk('public')->put('avatars', $request->avatar) : Storage::disk('public')->put('avatars', 'def.jpg');
        // register

        $user = User::create($fields);

        // login

        Auth::login($user);

        // redirect
        return redirect()->route('home')->with('message', 'User created successfully!');
    }
    public function login(Request $request)
    {
        // sleep(1);

        $fields = $request->validate([
            'email' => ['required', 'email'],

            'password' => ['required'],
        ]);

        if (Auth::attempt($fields, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->back()->with('message', 'Welcome back!');
        }

        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
<<<<<<< HEAD
=======
        
>>>>>>> 2a79c7e3c0681e4b9c4e00c23d755f56846b1f8b
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('message', 'You have been logged out successfully!');
    }
}
