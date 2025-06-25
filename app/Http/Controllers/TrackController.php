<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;
use Illuminate\Support\Facades\Storage;

class TrackController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $tracks = Track::latest()->get();
        return view('tracks.index', compact('tracks'));
    }

    public function create()
    {
        return view('tracks.create');
    }

public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'nullable|string|max:255',
            'file' => 'required|mimes:mp3,wav,ogg|max:20000',
        ]);
        $filePath = $request->file('file')->store('tracks', 'public');
        Track::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'file' => $filePath,
        ]);
        return redirect()->route('tracks.index')->with('success', 'Track succesvol toegevoegd!');
    } catch (\Exception $e) {
        dd($e->getMessage(), $e->getTraceAsString());
    }
}


    public function destroy(Track $track)
    {
        Storage::disk('public')->delete($track->file);
        $track->delete();
        return redirect()->route('tracks.index')->with('success', 'Track verwijderd!');
    }

    public function player()
    {
        $tracks = Track::latest()->get();
        return view('tracks.player', compact('tracks'));
    }

    public function edit(\App\Models\Track $track)
{
    return view('tracks.edit', compact('track'));
}

public function update(Request $request, \App\Models\Track $track)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'artist' => 'nullable|string|max:255',
    ]);

    $track->update($validated);

    return redirect()->route('tracks.index')->with('success', 'Track bijgewerkt!');
}

}
