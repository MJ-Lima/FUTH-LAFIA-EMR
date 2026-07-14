<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Users\UserIndex;
use App\Livewire\Users\UserCreate;
use App\Livewire\Users\UserEdit;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
	
	Route::get('users', [UserIndex::class, 'render'])->name('users.index');
	Route::get('users/create', [UserCreate::class, 'render'])->name('users.create');
	Route::get('users/{user}/edit', [UserEdit::class, 'render'])->name('users.edit');
	
});

require __DIR__.'/settings.php';
