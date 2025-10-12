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
        sleep(2);

        // validate

        $fields = $request->validate(
            rules: [
                'avatar' => ['file', 'image', 'max:3000', 'nullable'],
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed'],
            ],
        );

        $fields['password'] = bcrypt($fields['password']);

        if ($request->hasFile('avatar')) {
            $fields['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
        }
        // register

        $user = User::create($fields);

        // login

        Auth::login($user);

        // redirect
        return redirect()->route('dashboard')->with('message', 'User created successfully!');
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
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('message', 'You have been logged out successfully!');
    }
}
