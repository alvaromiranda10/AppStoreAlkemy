<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $applications = Application::with('categories')
                                    ->paginate(10);
        return view('client.index', compact('applications'));
    }

    public function listCategories(Application $application)
    {
        $categories = $application->select('categories.id', 'categories.name', DB::raw('count(applications.id) as cantapp'))
        ->join('categories', 'applications.category_id', '=', 'categories.id')
        ->groupBy('categories.id', 'categories.name')
        ->orderBy('name')
        ->get();

        return view('client.categories', compact('categories'));
    }

}
