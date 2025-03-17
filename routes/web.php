<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\VolunteerController;

Route::get('/', [VolunteerController::class, 'index'])->name('volunteer.index');
Route::get('/createcategory', [categoryController::class, 'createCategory'])->name('createCategory');

Route::post('/Category/store', [categoryController::class, 'store'])->name('categories.store');

Route::get('/Activity', [ActivityController::class, 'Activity']);
// Route::get('/', [ActivityController::class, 'Activity']);
