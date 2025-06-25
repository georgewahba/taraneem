<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuggestionsController; 
use App\Http\Controllers\TaraneemController;
use App\Http\Controllers\TrackController;
use App\Models\Taraneem;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Completion\Suggestion;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class,'index'])->name('home');

Route::get('/tarnima/{taraneem}', [TaraneemController::class, 'show'])->name('taraneem.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/taraneem', [TaraneemController::class, 'index'])->name('taraneem')->middleware(['auth', 'verified']);

Route::get('/addtaraneem', function () {
    return view('addtaraneem');
})->middleware(['auth', 'verified']);

Route::get('/edittaraneem/{taraneem}', [TaraneemController::class, 'edit'])->name('taraneem.edit')->middleware(['auth', 'verified']);
Route::get('/deletetaraneem/{taraneem}', [TaraneemController::class, 'destroy'])->name('taraneem.destroy')->middleware(['auth', 'verified']);
Route::post('/storetaraneem', [TaraneemController::class, 'store'])->name('storetaraneem');
Route::post('/updatetaraneem/{taraneem}', [TaraneemController::class, 'update'])->name('taraneem.update')->middleware(['auth', 'verified']);

Route::get('/browseall', [TaraneemController::class, 'browseall'])->name('browseall');

Route::get('/suggestion', [SuggestionsController::class, 'index'])->name('suggestion');
Route::post('/storesuggestion', [SuggestionsController::class, 'store'])->name('storesuggestion');
Route::get('/suggestedtaraneem', [SuggestionsController::class, 'suggestedtaraneem'])->name('suggestedtaraneem')->middleware(['auth', 'verified']);
Route::get('/showsuggested/{suggestion}', [SuggestionsController::class, 'showsuggested'])->name('showsuggested')->middleware(['auth', 'verified']);
Route::get('/deletesuggested/{suggestion}', [SuggestionsController::class, 'destroy'])->name('suggestion.destroy')->middleware(['auth', 'verified']);

Route::get('/player', [TrackController::class, 'player'])->name('tracks.player')->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tracks', [TrackController::class, 'index'])->name('tracks.index');
    Route::get('/tracks/create', [TrackController::class, 'create'])->name('tracks.create');
    Route::post('/tracks', [TrackController::class, 'store'])->name('tracks.store');
    Route::delete('/tracks/{track}', [TrackController::class, 'destroy'])->name('tracks.destroy');
    Route::get('/tracks/{track}/edit', [TrackController::class, 'edit'])->name('tracks.edit');
    Route::post('/tracks/{track}', [TrackController::class, 'update'])->name('tracks.update');


});



require __DIR__.'/auth.php';
