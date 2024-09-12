<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Like;
use App\Models\Comment;
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
        $likes = Like::where('users_id', $userId)->where('item_id', $item)->first();
        $likeCount = Like::where('users_id', $userId)->where('item_id', $item)->count();
        $CommentCount = Comment::where('item_id',$item)->count();

        return view('detail',compact('items','category_item','likes','likeCount','CommentCount'));
    }

    public function favorite(Request $request)
    {

        $item = $request->input('item_id');
        $userId = $request->input('users_id');

        Like::create([
            'users_id' => $userId,
            'item_id' => $item,
        ]);
        $items = Item::with('category_item','condition')->where('id',$item)->first();
        $category_item = CategoryItem::with('category','item')->where('item_id',$item)->first();
        $likes = Like::where('users_id',$userId)->where('item_id',$item)->get();
        $likeCount = Like::where('users_id', $userId)->where('item_id', $item)->count();

        return redirect()->back()->with('likeCount', $likeCount);

    }

    public function destroy(Request $request)
    {
        $userId = Auth::id();
        $item = $request->input('item_id');
        $likes = Like::where('users_id',$userId)->where('item_id',$item)->delete();

        $items = Item::with('category_item','condition')->where('id',$item)->first();
        $category_item = CategoryItem::with('category','item')->where('item_id',$item)->first();
        $likes = Like::where('users_id',$userId)->where('item_id',$item)->get();
        $likeCount = Like::where('users_id', $userId)->where('item_id', $item)->count();

        return redirect()->back()->with('likeCount', $likeCount);

    }
}
