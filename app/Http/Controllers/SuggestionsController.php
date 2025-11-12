<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

class SuggestionsController extends Controller
{
    public function index()
    {
        return view('suggestion');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titel'  => 'required',
            'lyrics' => 'required',
        ]);

        // Opslaan in DB
        $suggestion = new \App\Models\Sugestion();
        $suggestion->titel  = $request->titel;
        $suggestion->lyrics = $request->lyrics;
        $suggestion->save();

        toastr()->success('Jouw suggestie is opgeslagen. Bedankt voor je bijdrage!');

        // === Mailtrap API key send ===
        $apiKey = env('MAILTRAP_API_KEY');

        $body = 'Er is een nieuwe suggestie toegevoegd. Ga naar https://www.taraneem.nl/suggestedtaraneem de website om het te bekijken.';

        try {
            // Initialize Mailtrap client
            $client = MailtrapClient::initSendingEmails(apiKey: $apiKey);

            // Create and send email
            $email = (new MailtrapEmail())
                ->from(new Address(config('mail.from.address'), config('mail.from.name')))
                ->to(new Address('info@wahba.nl'))
                ->subject('Nieuwe suggestie toegevoegd')
                ->text($body);

            $client->send($email);

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