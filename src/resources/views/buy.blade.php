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
            </div>
            <div class="detail__change">
                <a href="" class="detail__change-link">変更する</a>
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
                <span>コンビニ払い</span>
            </div>
        </div>
        <div class="buy__form">
            <form action="/perchase/{{ $items->id }}" method="post" class="buy__form-content">
                @csrf
                <input type="hidden" name="item_id" value="{{$items->id}}">
                <input type="hidden" name="users_id" value="{{Auth::id()}}">
                <button type="submit" class="buy__button">購入する</button>
            </form>
             <button onClick="location.href='{{ route('cart.checkout') }}'" class="cart__purchase btn btn-primary">
        購入する
    </button>
        </div>
    </div>
</div>
@endsection