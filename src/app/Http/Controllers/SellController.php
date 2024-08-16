<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SellRequest;
use App\Models\Condition;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SellController extends Controller
{
    public function showSell()
    {
        $conditions = Condition::get();
        $categories = Category::get();

        return view('sell',compact('conditions','categories'));
    }

    public function sellItem(SellRequest $request)
    {
        $userId = Auth::id();
        $condition = Condition::where('condition',$request->input('condition'))->first();
        $category = Category::where('name',$request->input('categories'))->first();
        $image_path = $request->file('image_url')->store('public/images/');

        Item::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'image_url' => basename($image_path),
            'users_id' => $userId,
            'condition_id' => $request->input('condition'),
        ]);

        $item_id = Item::where('name',$request->input('name'))->value('id');
        $category_id = $request->input('categories');
        CategoryItem::create([
            'item_id' => $item_id,
            'category_id' => $category_id,
        ]);

        $item = Item::where('id',$item_id)->first();
        $category_item_id = CategoryItem::where('item_id',$item_id)->value('id');
        $item->update([
            'category_item_id' => $category_item_id,
        ]);

        return redirect('/');
    }

}
