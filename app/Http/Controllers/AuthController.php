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
                'password' => ['required', 'min:6', 'max:255', 'confirmed'],
                'remember' => ['boolean'],
            ],
        );

        $fields['password'] = bcrypt($fields['password']);

        $fields['avatar'] = $request->hasFile('avatar') ? Storage::disk('public')->put('avatars', $request->avatar) : Storage::disk('public')->put('avatars', 'def.jpg');
        // register

        $user = User::create($fields);

        $user->assignRole('user');

        // login

        Auth::login($user);

        // redirect
        return redirect()
            ->route('home')
            ->with([
                'message' => 'Welcome to the fight club!',
                'type' => 'success',
            ]);
    }
    public function login(Request $request)
    {
        // sleep(1);
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($fields, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect()->route('admin.index');
            }

            return redirect()
                ->intended('profile')
                ->with(['message' => 'Welcome back Commando!', 'type' => 'success']);
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

        return redirect()
            ->route('login')
            ->with([
                'message' => 'Sad to see you go!',
                'type' => 'info',
            ]);
    }
}
