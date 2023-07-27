<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $filename = $request->file('photo')->getClientOriginalName();
    $request->file('photo')->storeAs('shops', $filename);

    // Resize the uploaded image using Intervention/Image package
    $resizedImage = Image::make(storage_path('app/shops/' . $filename))
        ->fit(500, 500)
        ->encode();

    // Store the resized image in /storage/app/shops/resized-$filename
    $resizedFilename = 'resized-' . $filename;
    Storage::put('shops/' . $resizedFilename, $resizedImage);

    return 'Success';
}
}
