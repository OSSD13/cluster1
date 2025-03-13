<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function createCategory(){
        $category = Category::all();
        return view('createcategory', compact('category'));
    }
}
