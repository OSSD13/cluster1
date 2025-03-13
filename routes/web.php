<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\categoryController;

Route::get('/', [categoryController::class, 'createCategory']);
