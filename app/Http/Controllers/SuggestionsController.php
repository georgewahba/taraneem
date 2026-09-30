<?php

namespace App\Http\Controllers;

use Throwable;
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
        $validated = $request->validate([
            'titel'  => 'required|string|max:255',
            'lyrics' => 'required|string|max:200000',
        ]);

        $suggestion = new \App\Models\Sugestion();
        $suggestion->titel  = $validated['titel'];
        $suggestion->lyrics = $validated['lyrics'];
        $suggestion->save();

        $apiKey = config('services.mailtrap.token');
        $body = 'A new hymn suggestion is ready to review: ' . route('suggestedtaraneem');

        if ($apiKey && !app()->environment('testing')) {
            try {
                $client = MailtrapClient::initSendingEmails(apiKey: $apiKey);
                $email = (new MailtrapEmail())
                    ->from(new Address(config('mail.from.address'), config('mail.from.name')))
                    ->to(new Address(config('services.mailtrap.suggestions_recipient')))
                    ->subject('New hymn suggestion')
                    ->text($body);

                $client->send($email);
            } catch (Throwable $e) {
                report($e);
            }
        }

        return redirect()->route('home')->with('success', 'Your suggestion has been received. Thank you!');
    }

    public function suggestedtaraneem()
    {
        $suggestions = \App\Models\Sugestion::latest()->get();
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
