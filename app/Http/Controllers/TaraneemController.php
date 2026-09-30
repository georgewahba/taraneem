<?php

namespace App\Http\Controllers;

use App\Models\Taraneem;
use Illuminate\Http\Request;

class TaraneemController extends Controller
{
    public function index(){
        $taraneem = Taraneem::query()->orderBy('titel')->get();
        return view('taraneem', compact('taraneem'));
    }

    public function store(Request $request){

        $request->validate([
            'titel' => 'required|string|max:255',
            'lyrics' => 'required|string|max:200000'
        ]);
        $taraneem = new Taraneem();
        $taraneem->titel = $request->titel;
        $taraneem->lyrics = $request->lyrics;
        $taraneem->save();
        return redirect()->route('taraneem')->with('success', 'Hymn added successfully.');
    }

    public function show(Taraneem $taraneem){
        return view('showtaraneem', compact('taraneem'));
    }

    public function edit(Taraneem $taraneem){
        return view('edittaraneem', compact('taraneem'));
    }

    public function update(Request $request, Taraneem $taraneem){
        $request->validate([
            'titel' => 'required|string|max:255',
            'lyrics' => 'required|string|max:200000'
        ]);
        $taraneem->titel = $request->titel;
        $taraneem->lyrics = $request->lyrics;
        $taraneem->save();
        return redirect()->route('taraneem')->with('success', 'Hymn updated successfully.');
    }

    public function destroy(Taraneem $taraneem){
        $taraneem->delete();
        return redirect()->route('taraneem')->with('success', 'Hymn deleted successfully.');
    }
    

    public function browseall(){
        $taraneem = Taraneem::query()->orderBy('titel')->get();
        return view('browseall', compact('taraneem'));
    }
}
