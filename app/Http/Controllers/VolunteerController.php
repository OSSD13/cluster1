<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class VolunteerController extends Controller
{
    function index(){
        $categories = Category::all();
        return view('valunteer.overview',compact('categories'));
    }
    //
}
