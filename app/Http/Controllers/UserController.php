<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function redirect(Request $request)
    {
        if(Auth::check())           
        {
            if($request->user()->authorizeRoles(['developer']))
            {
                return redirect()->route('developer.index');
            }
            else
            {
                return redirect()->route('client.index');
            }
        }
        else
        {
                return redirect()->route('user.index');
        }
    }

    public function welcome()
    {
        return view('welcome');
    }
    
    public function index()
    {
        $applications = Application::with('categories')
                                    ->paginate(10);
        return view('client.index', compact('applications'));
    }
}
