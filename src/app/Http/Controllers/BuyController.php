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

    public function buyItem(Request $request)
    {
        $itemId = $request->input('item_id');
        $userId = $request->input('users_id');
        $items = Item::orderBy('id', 'DESC')->paginate(5);

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


    public function payment(Request $request)
    {
    try
    {
    Stripe::setApiKey(env("STRIPE_SECRET"));

    $customer = Customer::create(array(
    "email" => $request->stripeEmail,
    "source" => $request->stripeToken
    ));

    $charge = Charge::create(array(
    "customer" => $customer->id,
    "amount" => 2000,
    "currency" => "jpy"
    ));

    return redirect()->route("complete");
    }
    catch(Exception $e)
    {
    return $e->getMessage();
    }
    }
}
