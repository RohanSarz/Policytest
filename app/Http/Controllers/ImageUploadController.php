<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('tinymce-images', 'public');
            $url = Storage::url($path);
            
            return response()->json([
                'url' => $url
            ]);
        }

        return response()->json(['error' => 'No image uploaded'], 400);
    }
}