<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreApplicationRequest;

class DeveloperController extends Controller
{
    public function index()
    {
        $applications = Application::where('user_id', '=', Auth::user()->id)
                                    ->orderBy('id', 'desc')
                                    ->get();
        return view('developer.index', compact('applications'));
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('developer.create', compact('categories'));
    }
    
    public function store(StoreApplicationRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;

        $imageName = time().'.'.$request->image_src->extension();
        $request->image_src->move(public_path('images'), $imageName);
        $input['image_src'] = $imageName;

        $application = Application::create($input);

        $application->historicalPrice()->create($input);
        
        $categories = Category::all();
        return redirect()->route('developer.index', compact('categories'))->with('msj', 'App Created');
    }
    
    public function destroy($id)
    {
        $image_src = public_path('images') .DIRECTORY_SEPARATOR .Application::findOrFail($id)->image_src;

        if(file_exists($image_src))
        {
            unlink($image_src);
            Application::destroy($id);

            return redirect()->route('developer.index')->with('msj', 'App deleted');
        }
        
        return redirect()->route('developer.index')->with('msj', 'App not removed');
    }

    public function edit($id)
    {
        $application = Application::findOrFail($id);

        return view('developer.edit', compact('application'));
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $input = $request->all();

        
        if($application->price != $request->price)
        {
            $application->historicalPrice()->create($input);
        }

        if($request->has('image_src'))
        {            
            $input = $request->all();
            $input['image_src'] = $this->updateImageUrl($request, $id);
            Application::find($id)->update($input);
        }
        else
        {
            // $input = $request->only('price');
            Application::find($id)->update($input);
        }

        return redirect()->route('developer.index')->with('msj', 'App update');
    }

    public function updateImageUrl(Request $request, $id)
    {

        $imageName= Application::findOrFail($id)->image_src;
        $image_src = public_path('images') .DIRECTORY_SEPARATOR .$imageName;
        
        if(file_exists($image_src))
        {
            unlink($image_src);

            $imageName = time().'.'.$request->image_src->extension();
            $request->image_src->move(public_path('images'), $imageName); 
        }

        return $imageName;

    }
}
