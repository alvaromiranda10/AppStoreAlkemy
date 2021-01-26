<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            if($request->user()->roles->first()->name =='developer')
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
            return redirect()->route('user.welcome');
        }
    }

    public function index()
    {
        return view('welcome');
    }
    
    public function listsCategories(Application $application)
    {
        $categories = $application::select('categories.id', 'categories.name', DB::raw('count(applications.id) as cantapp'))
                                    ->join('categories', 'categories.id', '=', 'applications.category_id')
                                    ->groupBy('categories.id', 'categories.name')
                                    ->orderBy('name')
                                    ->get();

        return view('user.categories', compact('categories'));
    }

    public function listAppsCategory(Request $request, $category_id)
    {
        $applications = Application::where('category_id', '=', $category_id)
                        ->orderBy('id', 'desc')
                        ->paginate(10);
        $category = Category::findOrFail($category_id);

        return view('user.apps', compact('applications', 'category'));
    }

    public function appDetail(Request $request, $id)
    {
        $application = Application::with('categories')
                        ->where('id', '=', $id)
                        ->first();

        return view('user.detail', compact('application'));
    }
}