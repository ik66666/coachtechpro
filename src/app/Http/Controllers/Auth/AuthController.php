<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminEmail;
use App\Http\Requests\MailRequest;



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

    public function showEmail($user)
    {
        $user = User::where('id',$user)->first();
        return view('mail/mail-form',compact('user'));
    }

    public function sendEmail(MailRequest $request)
    {

        $data = [
        'message' => $request->input('message'),
        ];
        $email = new AdminEmail($data);

        $user = User::where('id', $request->user)->first();
        $user_email = $user->email;

        Mail::to($user_email)->send($email);

        if (count(Mail::failures()) > 0) {
			return back()->with('flash_message', 'メール送信に失敗しました');
        }
        else{
			return redirect()->route('admin.index')->with('flash_message', 'メール送信しました');
        }

    }
}