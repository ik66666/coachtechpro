<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Profile;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;


class BuyController extends Controller
{
    public function showBuy($item)
    {
        $userId = Auth::id();
        $items = Item::where('id',$item)->first();
        $profile = Profile::where('users_id',$userId)->first();
        return view('buy',compact('items','profile'));
    }

    public function buyItem($item)
    {
        $itemId = $item;
        $userId = Auth::id();
        $items = Item::orderBy('id', 'DESC')->paginate(15);

        SoldItem::create([
            'users_id' => $userId,
            'item_id' => $itemId,
        ]);

        return view('index',compact('items'));
    }

    public function editAddress()
    {

        return view('address');
    }

    public function addAddress(AddressRequest $request)
    {
        $items = $request->all();
        $userId = Auth::id();
        unset($items['_token']);
        Profile::where('users_id',$userId)->update($items);

        return redirect()->back();
    }


    public function charge(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));//シークレットキー
 
        $charge = Charge::create(array(
             'amount' => $request->input('price'),
             'currency' => 'jpy',
             'source'=> request()->stripeToken,
         ));

         $item = $request->input('item_id');
       return $this->buyItem($item);
    }
}
