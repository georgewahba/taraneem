<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaraneemController;
use App\Models\Taraneem;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
