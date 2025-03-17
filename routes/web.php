<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\ActivityController;

Route::get('/', function () {
    return view('overview');
});
Route::get('/createcategory', function () {
    return view('createCategory');
});
Route::get('/Category/create', [categoryController::class, 'createCategory']);

Route::post('/Category/create', [categoryController::class, 'store'])->name('categories.store');

Route::get('/Activity', [ActivityController::class, 'Activity']);
// Route::get('/', [ActivityController::class, 'Activity']);
