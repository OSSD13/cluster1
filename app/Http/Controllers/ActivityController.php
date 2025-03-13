<?php

namespace App\Http\Controllers;

use App\Models\activities;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    function Activity(){
        $activiry = activities::all();
        return view('CreateActivity', compact('Category'));
    }
}
