<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HouseController extends Controller
{
    public function store(Request $request)
    {
        $filename = $request->file('photo')->store('houses');

        House::create([
            'name' => $request->name,
            'photo' => $filename,
        ]);

        return 'Success';
    }


public function update(Request $request, House $house)
{
    // Get the old filename from the database
    $oldFilename = $house->photo;

    $filename = $request->file('photo')->store('houses');

    // Update the House model with the new data
    $house->update([
        'name' => $request->name,
        'photo' => $filename,
    ]);

    // Delete the old file from the storage if it exists
    if ($oldFilename && Storage::exists($oldFilename)) {
        Storage::delete($oldFilename);
    }

    return 'Success';
}


public function download(House $house)
{
    $filePath = storage_path('app/houses/' . $house->photo);

    if (!Storage::exists($filePath)) {
        abort(200, 'File not found');
    }

    return response()->download($filePath, $house->photo);
}
}
