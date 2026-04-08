<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Optional POST route for login submission
Route::post('/login', function () {
    // Handle login logic here or redirect to Laravel's auth controller
    return redirect('/dashboard');
});
