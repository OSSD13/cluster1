<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class categoryController extends Controller
{
    function createCategory(){
        $categories = Category::all();
        return view('valunteer.createActivity',compact('categories'));
    }
}
