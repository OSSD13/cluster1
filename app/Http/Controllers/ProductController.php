<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('product');
    }
    function store(Request $request)
    {
        return redirect('/product');
    }
}
