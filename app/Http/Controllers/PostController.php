<?php

namespace App\Http\Controllers;


use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Post/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        return redirect()->route('home')->with('message', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fields = $request->validate(
            rules: [
                'avatar' => ['file', 'image', 'max:3000', 'nullable'],
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
