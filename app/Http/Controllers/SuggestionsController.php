<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuggestionsController extends Controller
{
    public function index()
    {
        return view('suggestion');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'titel' => 'required',
            'lyrics' => 'required',
        ]);
        
        $suggestion = new \App\Models\Sugestion();
        $suggestion->titel = $request->titel;
        $suggestion->lyrics = $request->lyrics;
        $suggestion->save();
        
        toastr()->success('Jouw suggestie is opgeslagen. Bedankt voor je bijdrage!');
        return redirect("/");
    }

    public function suggestedtaraneem()
    {
        $suggestions = \App\Models\Sugestion::all();
        return view('suggestedtaraneem', compact('suggestions'));
    }

    public function showsuggested(\App\Models\Sugestion $suggestion)
    {
        return view('showsuggested', compact('suggestion'));
    }

    public function destroy(\App\Models\Sugestion $suggestion)
    {
        $suggestion->delete();
        return redirect("/suggestedtaraneem")->with('success', 'Suggestion deleted successfully.');
    }
}

