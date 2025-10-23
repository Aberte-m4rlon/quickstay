<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Minimal stub to satisfy route:list / route definitions.
    public function index()
    {
        return abort(404); // or return view('admin.index') if you have one
    }
    
}
             