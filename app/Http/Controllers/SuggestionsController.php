<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        // $MailData = [
        //     'title' => 'Email From Taraneem.nlh',
        //     'body' => 'Er is een nieuwe suggestie toegevoegd. Ga naar https://www.taraneem.nl/suggestedtaraneem de website om het te bekijken.'
        // ];

        // Mail::to("george-wahba@hotmail.com")->send(new SendMail($MailData));


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

