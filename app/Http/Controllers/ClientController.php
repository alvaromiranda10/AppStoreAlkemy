<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Wish_list;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ClientController extends Controller
{
    public function index()
    {
        $wish_list =Wish_list::where('user_id', Auth::user()->id)->first();
        $wish_list_app = $wish_list->applications()->get();

        $cart = Cart::where('user_id', Auth::user()->id)->first();
        $cart_app = $cart->applications()->get();

        return view('client.index', compact('wish_list_app', 'cart_app'));
    }

    public function listsCategories(Application $application)
    {
        $categories = $application::select('categories.id', 'categories.name', DB::raw('count(applications.id) as cantapp'))
                                    ->join('categories', 'categories.id', '=', 'applications.category_id')
                                    ->groupBy('categories.id', 'categories.name')
                                    ->orderBy('name')
                                    ->get();

        return view('client.categories', compact('categories'));
    }

    public function listAppsCategory($category_id)
    {
        $applications = Application::where('category_id', '=', $category_id)
                        ->orderBy('id', 'desc')
                        ->paginate(10);
        $category = Category::findOrFail($category_id);

        return view('client.apps', compact('applications', 'category'));
    }

    public function appDetail($id)
    {
        $verifyBuy = $this->verifyAppBuy(Auth::user()->id, $id);
        $verifyWish = $this->verifyAppWish(Auth::user()->id, $id);

        $application = Application::with('categories')
                        ->where('id', '=', $id)
                        ->first();

        return view('client.detail', compact('application','verifyBuy', 'verifyWish'));
    }

    public function buyApp(Request $request)
    {
        $resp = $this->verifyAppBuy(Auth::user()->id, $request->application_id);

        if(empty($resp->cart_app))
        {
            $wish_list = Wish_list::where('user_id', Auth::user()->id)->first();
            $wish_list->applications()->detach($request->application_id);

            $resp->cart->applications()->attach($request->application_id);

            return  response()->json('Successful purchase');
        }
        else
        {
            return  response()->json('Is already on your shoping list.');
        }
    }

    public function wishApp(Request $request)
    {
        $resBuy = $this->verifyAppBuy(Auth::user()->id, $request->application_id);
        $resWish = $this->verifyAppWish(Auth::user()->id, $request->application_id);

        if(empty($resWish->wish_list_app) && empty($resBuy->cart_app))
        {
            $resWish->wish_list->applications()->attach($request->application_id);
        }

        return redirect()->route('client.appdetail', ['id' => $request->application_id])->with('msj','Added to wish list');
    }

    public function deleteBuyApp(Request $request)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->first();

        $cart->applications()->detach($request->application_id);

        return response()->json('App removed from cart');
    }
    
    public function deleteWishApp(Request $request)
    {
        $wish_list = Wish_list::where('user_id', Auth::user()->id)->first();

        $wish_list->applications()->detach($request->application_id);

        return redirect()->route('client.index')->with('msj','Removed from wish list');
    }


    public function verifyAppBuy($user_id, $application_id)
    {
        $cart =Cart::where('user_id', $user_id)->first();

        $cart_app = $cart->applications()->where( function(Builder $q) use ($application_id) {
            return $q->where('application_id', $application_id);
        })->first();

        return (object) ['cart' => $cart,'cart_app' => $cart_app];
    }

    public function verifyAppWish($user_id, $application_id)
    {
        $wish_list =Wish_list::where('user_id', $user_id)->first();

        $wish_list_app = $wish_list->applications()->where( function(Builder $q) use ($application_id) {
            return $q->where('application_id', $application_id);
        })->first();

        return (object) ['wish_list' => $wish_list,'wish_list_app' => $wish_list_app];
    }

}
