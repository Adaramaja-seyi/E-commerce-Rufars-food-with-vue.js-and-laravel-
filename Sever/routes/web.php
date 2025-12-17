<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Debug route to check Google OAuth config
Route::get('/debug-google', function () {
    return response()->json([
        'client_id' => config('services.google.client_id'),
        'redirect_uri' => config('services.google.redirect'),
        'app_url' => config('app.url'),
    ]);
});
