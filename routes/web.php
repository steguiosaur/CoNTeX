<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VaultController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/vaults', [VaultController::class, 'index'])->name('vaults.index');
    Route::post('/vaults', [VaultController::class, 'store'])->name('vaults.store');
    Route::patch('/vaults/{vault}', [VaultController::class, 'update'])->name('vaults.update');
    Route::delete('/vaults/{vault}', [VaultController::class, 'destroy'])->name('vaults.destroy');
    Route::delete('/vaults/{vault}/collaborators/me', [VaultController::class, 'destroy'])->name('vaults.collaborators.me.delete');
    Route::get('/vaults/{vault}', [VaultController::class, 'show'])->name('vaults.show');

    // implement api for deleting user collaborator accessing owned vault, folder, file
    // implement api for adding, showing, editing, deleting folders and files

    Route::get('/api/v1/vaults/{vault}/nodes', [VaultExplorererController::class, 'index'])->name('tree.index');
    Route::get('/api/v1/files/{file}/blocks', [FileBlockController::class, 'index'])->name('blocks.index');
    Route::patch('api/v1/blocks/{block}', [FileBlockController::class, 'update'])->name('blocks.update');
});

require __DIR__ . '/auth.php';
