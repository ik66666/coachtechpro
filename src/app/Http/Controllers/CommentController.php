<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function showComment($item)
    {
        $userId = Auth::id();
        $items = Item::with('category_item','condition')->where('id',$item)->first();
        $likes = Like::where('users_id',$userId)->where('item_id',$item)->first();
        $comments = Comment::with('user')->where('item_id',$item)->get();
        return view('comment',compact('comments','items','likes'));
    }

    public function postComment(CommentRequest $request)
    {
        $item = $request->input('item_id');
        $user = $request->input('users_id');
        $comment = $request->input('comment');

        Comment::create([
            'item_id' => $item,
            'users_id' => $user,
            'comment' => $comment,
        ]);

        return redirect()->route('item.comment',[$request->input('item_id')]);
    }
}
