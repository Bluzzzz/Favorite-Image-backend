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
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'required|image|max:2048',
    ]);

    $file = $request->file('image');

$filename = time().'_'.$file->getClientOriginalName();

$file->move(public_path('storage/favorites'), $filename);

$path = 'favorites/'.$filename;



    $image = FavoriteImage::create([
        'title' => $request->title,
        'description' => $request->description,
        'image_path' => $path,
    ]);

    return response()->json($image, 201);
}



    // DELETE
   public function destroy($id)
{
    FavoriteImage::findOrFail($id)->delete();
    return response()->json(['message' => 'deleted']);
}

}

