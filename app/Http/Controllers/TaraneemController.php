<?php

namespace App\Http\Controllers;

use App\Models\Taraneem;
use Illuminate\Http\Request;

class TaraneemController extends Controller
{
    public function index(){
        $taraneem = Taraneem::all();
        return view('taraneem', compact('taraneem'));
    }

    public function store(Request $request){

        $request->validate([
            'titel' => 'required',
            'lyrics' => 'required'
        ]);
        $taraneem = new Taraneem();
        $taraneem->titel = $request->titel;
        $taraneem->lyrics = $request->lyrics;
        $taraneem->save();
        return redirect("/taraneem");
    }

    public function show(Taraneem $taraneem){
        return view('showtaraneem', compact('taraneem'));
    }

    public function edit(Taraneem $taraneem){
        return view('edittaraneem', compact('taraneem'));
    }

    public function update(Request $request, Taraneem $taraneem){
        $request->validate([
            'titel' => 'required',
            'lyrics' => 'required'
        ]);
        $taraneem->titel = $request->titel;
        $taraneem->lyrics = $request->lyrics;
        $taraneem->save();
        return redirect("/taraneem");
    }

    public function destroy(Taraneem $taraneem){
        $taraneem->delete();
        return redirect("/taraneem");
    }
    
}
