<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index(Request $request)
    {
        
        return view('client.index');
    }
    
    public function indextwo(Request $request)
    {
        return view('developer.index');
    }
}
