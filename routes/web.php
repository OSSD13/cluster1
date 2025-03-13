<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('default');
});
Route::get('/de', function () {
    return view('layout.default');
});

