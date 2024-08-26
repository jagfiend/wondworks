<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Posts\ShowController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// posts
Route::get('/posts/{post}', ShowController::class)->name('posts.show');

// things
Route::get('/doodler', fn () => view('things.doodler'))->name('doodler');
