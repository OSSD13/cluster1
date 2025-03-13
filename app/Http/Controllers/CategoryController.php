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

    public function store(Request $request)
    {
        $request->validate([
            'cat_name' => 'required|unique:categories|max:100',
            'description' => 'nullable|string',
            'cat_ismandatory' => 'required|boolean',
            'due_date' => 'nullable|date|after:today', // ต้องเป็นวันที่อนาคต
        ]);

        Category::create([
            'cat_name' => $request->cat_name,
            'description' => $request->description,
            'cat_ismandatory' => $request->cat_ismandatory,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('createCategory')->with('success', 'Category created successfully, pending approval.');
    }
}
