<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\ActivityController;

Route::get('/Category/create', [categoryController::class, 'createCategory']);
Route::get('/', function () {
    return view('welcome');
});
Route::get('/de', function () {
    return view('layout.default');
});

Route::post('/Category/create', [categoryController::class, 'store']);

Route::get('/Activity', [ActivityController::class, 'Activity']);
Route::get('/', [ActivityController::class, 'Activity']);