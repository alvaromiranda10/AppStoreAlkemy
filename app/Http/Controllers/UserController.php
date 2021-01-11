<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->user()->authorizeRoles(['client']))           
        {
            return redirect('/me/apps/lists');  
        }
        else
        {
            return redirect('/me/apps');
        }
    }
}
