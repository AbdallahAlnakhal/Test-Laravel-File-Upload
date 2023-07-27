<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
            'name' => 'required|string',
        ]);

        $originalFilename = $request->file('logo')->getClientOriginalName();

        $project = new Project;
        $project->name = $request->name; // Use the value from the request
        $project->title = 'title'; // Set the title attribute
        $project->logo = $originalFilename; // Use the original filename
        $project->save();
        $logoPath = $request->file('logo')->store('public/logos');

        return redirect()->back();
    }
}

