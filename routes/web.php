<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route home baru
Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Route dashboard
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

// Auth Routes (sementara tanpa middleware dulu)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Testing layout
Route::get('/test', function () {
    return view('layouts.app');
});

// Keep welcome for testing
Route::get('/welcome', function () {
    return view('welcome');
});