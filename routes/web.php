<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VaultController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('HomePage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('home');

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register');

Route::get('/profile', function () {
    return Inertia::render('Profile/Edit');
})->middleware(['auth', 'verified'])->name('profile');

// Route::get('/editor', function () {
//     return Inertia::render('EditorPage');
// })->middleware(['auth', 'verified'])->name('editor');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('vaults', VaultController::class);

    Route::prefix('vaults/{vault}')->group(function () {
        Route::resource('documents', DocumentController::class)->except(['index', 'show', 'create', 'store']);
        Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::get('/editor', [DocumentController::class, 'edit'])->name('vaults.editor');
    });
});

require __DIR__ . '/auth.php';
