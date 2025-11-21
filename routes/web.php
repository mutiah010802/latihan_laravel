<?php

use Illuminate\Support\Facades\Route;

// Route home baru - mengarah ke pages/home.blade.php
Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Route dashboard - mengarah ke pages/dashboard.blade.php  
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

// Auth Routes - mengarah ke auth folder
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Testing
Route::get('/test', function () {
    return "Test berhasil!";
});