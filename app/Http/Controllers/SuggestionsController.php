<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\SendMail;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $receiverNumber = '+31640933995'; 
        $message = 'Er is een nieuwe suggestie toegevoegd. Ga naar https://www.taraneem.nl/suggestedtaraneem de website om het te bekijken.'; 

        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $fromNumber = env('TWILIO_FROM');

        try {
            $client = new Client($sid, $token);
            $client->messages->create($receiverNumber, [
                'from' => $fromNumber,
                'body' => $message
            ]);

            return redirect("/");
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
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

