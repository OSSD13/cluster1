<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); 
});
Route::get('/de', function () {
    return view('layout.default');
});

