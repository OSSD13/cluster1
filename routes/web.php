<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('valunteer.createActivity');
});
Route::get('/de', function () {
    return view('layout.default');
});

