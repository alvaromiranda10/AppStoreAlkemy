<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Application;
use App\Models\Historical_price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperController extends Controller
{
    public function index(Request $request)
    {
        $applications = Application::with('categories')
                                    ->where('user_id', '=', Auth::user()->id)
                                    ->get();
        return view('developer.index', compact('applications'));
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('developer.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $imageName = time().'.'.$request->image_src->extension();
        $request->image_src->move(public_path('images'), $imageName);
        $input['image_src'] = $imageName;
        $application = Application::create($input);
        
        Historical_price::create([
            'price' => $application->price,
            'application_id' => $application->id
        ]);

        $categories = Category::all();
        return redirect()->route('developer.index', compact('categories'))->with('success', 'App Created');
    }
    
    public function destroy($id)
    {
        $image_src = public_path('images') .DIRECTORY_SEPARATOR .Application::findOrFail($id)->image_src;

        if(file_exists($image_src))
        {
            unlink($image_src);
            Application::destroy($id);
        }

        return redirect()->route('developer.index')->with('success', 'App deleted');
    }

    public function edit($id)
    {

        $application = Application::with('categories')
                    ->where('id', '=', $id)
                    ->first();

        return view('developer.edit', compact('application'));
    }

    public function update(Request $request, $id)
    {
        if($request->has('image_src'))
        {            

            $this->recordPriceHistory($request, $id);

            $input = $request->all();
            $input['image_src'] = $this->updateImageUrl($request, $id);
            Application::find($id)->update($input);
            
        }
        else
        {
            
            $this->recordPriceHistory($request, $id);
            Application::find($id)->update($request->only('price'));
        }
                
        return redirect()->route('developer.index')->with('success', 'App update');

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

    public function recordPriceHistory(Request $request, $id)
    {
        $application = Application::findOrFail($id);
            if($application->price != $request->price)
            {
                Historical_price::create([
                    'price' => $request->price,
                    'application_id' => $id
                    ]);
            }
    }
    
}
