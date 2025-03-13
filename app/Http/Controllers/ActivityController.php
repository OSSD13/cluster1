<?php

namespace App\Http\Controllers;

use App\Models\activities;
use App\Models\Category;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    function Activity(){
        $categories= Category::all();
        return view('valunteer.createActivity', compact('categories'));
    }
}
