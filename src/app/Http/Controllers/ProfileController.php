<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\SoldItem;
use App\Http\Requests\ProfileRequest;


class ProfileController extends Controller
{
    

    public function mypage()
    {
        $user = Auth::user();
        $profile = Profile::where('users_id',Auth::id())->first();
        $items = $user->soldItems()->orderBy('id','DESC')->get();
        return view('mypage',compact('items','user','profile'));
    }

    public function myBuyItem()
    {
        $user = Auth::user();
        $userId = Auth::id();
        $profile = Profile::where('users_id',Auth::id())->first();
        $items = SoldItem::with('user','item')->where('users_id',$userId)->orderBy('id', 'DESC')->paginate(5);;
        return view('buy-item',compact('items','user','profile'));
    }

    public function profile()
    {
        return view('profile');
    }

    public function editProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        $userId = Auth::id();
        $profile = Profile::where('users_id',$userId)->first();
        $image_path = $request->file('image_url')->store('public/images/');

        if( !$profile ){
        Profile::create( [
            'users_id' => $userId,
            'name' => $request->input('name'),
            'image_url' => basename($image_path),
            'postcode' => $request->input('postcode'),
            'address' => $request->input('address'),
            'building' =>   $request->input('building'),
        ]);
        }else{
            $items = [
            'users_id' => $userId,
            'name' => $request->input('name'),
            'image_url' => basename($image_path),
            'postcode' => $request->input('postcode'),
            'address' => $request->input('address'),
            'building' => $request->input('building'),

            ];
        $profile->update($items);
        }

        session()->flash('success', 'プロフィールを更新しました');


        return redirect()->back();


    }
}
