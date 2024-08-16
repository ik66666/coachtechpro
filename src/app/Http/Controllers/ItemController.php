<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;




class ItemController extends Controller
{
    public function index()
    {

        $items = Item::orderBy('id', 'DESC')->paginate(15);

        return view('index',compact('items'));
    }

    public function myFavorite()
    {
        $userId = Auth::id();
        $items = Like::with('user','item')->where('users_id',$userId)->orderBy('id', 'DESC')->paginate(15);

        return view('favorite',compact('items'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = Item::query();

        if(!empty($keyword)){
            $query->where('name','LIKE', "%{$keyword}%");
        }

        $items = $query->orderBy('id','DESC')->paginate(15);

        return view('index',compact('items'));
    }

    public function itemDetail($item)
    {
        $userId = Auth::id();

        $items = Item::with('category_item','condition')->where('id',$item)->first();
        $category_item = CategoryItem::with('category','item')->where('item_id',$item)->first();
        $likes = Like::where('users_id',$userId)->where('item_id',$item)->first();
        return view('detail',compact('items','category_item','likes'));
    }

    public function favorite(Request $request)
    {
        $item = $request->input('item_id');
        $user = $request->input('users_id');

        Like::create([
            'users_id' => $user,
            'item_id' => $item,
        ]);

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $userId = Auth::id();
        $item = $request->input('item_id');
        $likes = Like::where('users_id',$userId)->where('item_id',$item)->delete();

        return redirect()->back();
    }
}
