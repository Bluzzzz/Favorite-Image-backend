<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoriteImage;

class FavoriteImageController extends Controller
{
    // SHOW LIST
   public function index()
{
    return response()->json(
        FavoriteImage::latest()->get()
    );
}

    // STORE DATA
   public function store(Request $request)
{
    $request->validate([
        'title' => 'required|max:255',
        'image' => 'required|image|max:2048',
    ]);

    $path = $request->file('image')->store('favorites', 'public');

    $image = FavoriteImage::create([
        'title' => $request->title,
        'description' => $request->description,
        'image_path' => $path,
    ]);

    return response()->json($image);
}


    // DELETE
   public function destroy($id)
{
    FavoriteImage::findOrFail($id)->delete();
    return response()->json(['message' => 'deleted']);
}

}

