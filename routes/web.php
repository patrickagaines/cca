<?php

use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return redirect()->route('dashboard.posts.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('/dashboard/posts', PostController::class)
     ->middleware(['auth', 'verified'])
     ->names('dashboard.posts');

Route::resource('/dashboard/services', ServiceController::class)
    ->middleware(['auth', 'verified'])
    ->names('dashboard.services');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
