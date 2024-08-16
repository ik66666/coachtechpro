<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Comment;


class AuthController extends Controller
{
    public function showLogin() {

        return view('admin/login_form');

    }

    public function login(AdminRequest $request) {

        $credentials = $request->only(['email', 'password']);

        if(\Auth::guard('admin')->attempt($credentials)) {

            return redirect('/admin'); 

        }

        return back()->withErrors([
            'auth' => ['認証に失敗しました']
        ]);
    }

    public function index()
    {
        $users = User::all();
        return view('admin/admin',compact('users'));
    }

    public function showComment($user)
    {
        $comments = Comment::with('item')->where('users_id',$user)->orderBy('id', 'DESC')->paginate('15');
        return view('admin/user_comment',compact('comments'));
    }

    public function deleteUser($user)
    {
        User::where('id',$user)->delete();
        
        return redirect('/admin');
    }

    public function deleteComment($comment)
    {
        Comment::where('id',$comment)->delete();
        
        return redirect()->back();
    }
}