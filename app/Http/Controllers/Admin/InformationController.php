<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information;

class InformationController extends Controller
{
    public function index() {
        $informations = Information::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.informations.index', compact('informations'));
    }
    public function infoIndex() {
        $informations = Information::orderBy('updated_at', 'desc')->paginate(10);
        return view('info.index', compact('informations'));
    }
    public function create() {
        return view('admin.informations.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_link' => 'nullable|url',
            'video_upload' => 'nullable|mimes:mp4,mov,avi|max:10240'
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/info_images', 'public');
        }

        // Handle video upload
        if ($request->hasFile('video_upload')) {
            $data['video_upload'] = $request->file('video_upload')->store('uploads/info_videos', 'public');
        }

        Information::create($data);

        return redirect()->route('admin.informations.index')->with('success', 'Information added successfully!');
    }

    public function edit(Information $information) {
        return view('admin.informations.edit', compact('information'));
    }

    public function update(Request $request, Information $information) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_link' => 'nullable|url',
            'video_upload' => 'nullable|mimes:mp4,mov,avi|max:10240'
        ]);

        $data = $request->all();

        // Handle image update
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/info_images', 'public');
        }

        // Handle video update
        if ($request->hasFile('video_upload')) {
            $data['video_upload'] = $request->file('video_upload')->store('uploads/info_videos', 'public');
        }

        $information->update($data);

        return redirect()->route('admin.informations.index')->with('success', 'Information updated successfully!');
    }

    public function destroy(Information $information) {
        $information->delete();
        return redirect()->route('admin.informations.index')->with('success', 'Information deleted successfully!');
    }
    
}
