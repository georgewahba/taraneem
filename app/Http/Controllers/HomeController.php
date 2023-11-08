<?php

namespace App\Http\Controllers;

use App\Models\Taraneem;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $taraneem = Taraneem::all();
        return view('home', compact('taraneem'));
    }
}
