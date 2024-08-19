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
use Stripe\PaymentIntent;


class BuyController extends Controller
{
    public function showBuy($item)
    {
        $userId = Auth::id();
        $items = Item::where('id',$item)->first();
        $profile = Profile::where('users_id',$userId)->first();
        $paymethod = "クレジットカード";
        return view('buy',compact('items','profile','paymethod'));
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

        session()->flash('success', '商品の購入が完了しました');

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


    public function showPaymethod($item)
    {
        $item_id = $item;
        return view('cart.change',compact('item_id'));
    }

    public function changePaymethod(Request $request)
    {
        $userId = Auth::id();
        $item = $request->input('item_id');
        $paymethod = $request->input('paymethod');
        $items = Item::where('id',$item)->first();
        $profile = Profile::where('users_id',$userId)->first();
        return view('buy',[
            'item' => $item,
            'paymethod' => $paymethod,
            'items' => $items,
            'profile' => $profile,
        ]);
    }
    public function charge(Request $request)
    {
        Stripe::setApikey(env('STRIPE_SECRET'));

        $paymentMethods = ['card'];


        $paymentMethod = $request->input('paymethod')

        if($paymentMethod == 'konbini'){
            $paymentMethods[] = 'konbini';
        }elseif($paymentMethod == 'bank_transfer'){
            $paymentMethods[] = 'bank_transfer';
        }

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => $paymentMethods,
            'line_items' => [
            [
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $request->input('name'), 
                    ],
                    'unit_amount' => $request->input('price'), 
                ],
                'quantity' => 1, 

            ],
        ],
            'mode' => 'payment',
            'success_url' => route('bought.item',['item' => $request->input('item_id')]),
            'cancel_url'  => route('buy.item',['item' => $request->input('item_id')]),
        ]);
 
       return view('cart.checkout',[
            'session' => $session,
            'publicKey' => env('STRIPE_KEY')
       ]);
    }
}
