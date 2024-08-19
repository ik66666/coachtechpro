@extends('layouts.app2')

@section('title')
商品購入ページ
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/buy.css') }}">
@endsection

@section('content')

<div class="buy__content">
    <div class="item__detail">
        <div class="item__detail-top">
            <div class="item__detail-image">
                <img src="{{ asset('storage/images/' . $items->image_url) }}" class="item__image-file">
            </div>
            <div class="item__detail-label">
            <span class="item__detail-name">{{ $items->name }}</span>
            <span class="item__detail-price">¥{{ number_format($items->price) }}</span>
            </div>
        </div>
        <div class="payment__method">
            <div class="detail">
                <span class="detail__title">支払い方法</span>
                <span class="detail__method">
                    @if($paymethod == "konbini")
                    コンビニ払い
                    @elseif($paymethod == "bank_transfer")
                    銀行振込
                    @else
                    {{ $paymethod }}
                    @endif
                </span>
            </div>
            <div class="detail__change">
                <a href="/change/{{ $items->id }}" class="detail__change-link">変更する</a>
            </div>
        </div>
        <div class="user__address">
            <div class="detail">
                <span class="detail__title">配送先</span>
                <div class="user__address-detail">
                    <span class="address__detail-item">郵便番号：{{$profile->postcode}}</span>
                    <span class="address__detail-item">住所：{{$profile->address}}</span>
                    @isset($profile->building)
                    <span class="address__detail-item">建物名：{{$profile->building}}</span>
                    @endisset
                </div>
            </div>
            <div class="detail__change">
                <a href="/address" class="detail__change-link">変更する</a>
            </div>
        </div>
    </div>
    <div class="buy__content-right">
        <div class="payment__detail">
            <div class="item__price">
                <span class="title__top">商品代金</span>
                <span>¥{{ number_format($items->price) }}</span>
            </div>
            <div class="item__price">
                <span class="title">支払い金額</span>
                <span>¥{{ number_format($items->price) }}</span>
            </div>
            <div class="item__price">
                <span class="title">支払い方法</span>
                <span> 
                    @if($paymethod == "konbini")
                    コンビニ払い
                    @elseif($paymethod == "bank_transfer")
                    銀行振込
                    @else
                    {{ $paymethod }}
                    @endif
                </span>
            </div>
        </div>
        <div class="buy__form">
            <form id="payment-form" action="/charge" method="POST">
                @csrf

                <button  type="submit" class="buy__button">
            
                    購入する
                </button>
                <input type="hidden" name="name" value="{{ $items->name}}">
                <input type="hidden" name="price" value="{{ $items->price}}">
                <input type="hidden" name="item_id" value="{{$items->id}}">

                <input type="hidden" name="name" value="{{ $paymethod }}">
            </form>
        </div>
    </div>
</div>


@endsection