<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VaultController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\FileBlockController;
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
    // Manage Profiles page
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Manage VaultsPage
    Route::get('/vaults', [VaultController::class, 'index'])->name('vaults.index');
    Route::post('/vaults', [VaultController::class, 'store'])->name('vaults.store');
    Route::patch('/vaults/{vault}', [VaultController::class, 'update'])->name('vaults.update');
    Route::delete('/vaults/{vault}', [VaultController::class, 'destroy'])->name('vaults.destroy');
    Route::delete('/vaults/{vault}/collaborators/me', [VaultController::class, 'destroy'])->name('vaults.collaborators.me.delete');
    Route::get('/vaults/{vault}', [VaultController::class, 'show'])->name('vaults.show');

    // EditorPage routes
    // Manage Folders
    Route::post('/vaults/{vault}/folders',[FolderController::class, 'store'])->name('folders.store');
    Route::patch('/folders/{folder}',[FolderController::class, 'update'])->name('folders.update');
    Route::delete('/folders/{folder}',[FolderController::class, 'destroy'])->name('folders.destroy');

    // Manage Files
    Route::post('/vaults/{vault}/files', [FileController::class, 'store'])->name('files.store');
    Route::patch('/files/{file}', [FileController::class, 'update'])->name('files.update');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');

    // Manage Blocks
    // Route::put('/files/{file}/sync-blocks',[FileBlockController::class, 'syncBlocks']);
    Route::get('/files/{file}/blocks', [FileBlockController::class, 'index']); // Show current file blocks
    Route::post('/files/{file}/blocks',[FileBlockController::class, 'store']); // Create block
    Route::patch('/blocks/{block}',[FileBlockController::class, 'update']); // Update block
    Route::delete('/blocks/{block}',[FileBlockController::class, 'destroy']); // Delete block
});

require __DIR__ . '/auth.php';
