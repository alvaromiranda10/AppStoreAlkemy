<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $applications = Application::with('categories')
                                    ->paginate(10);
        return view('client.index', compact('applications'));
    }
}
