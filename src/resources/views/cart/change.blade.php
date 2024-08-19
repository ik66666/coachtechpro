@extends('layouts.app2')

@section('title')
支払方法選択
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/change.css') }}">
@endsection

@section('content')
<div class="change content">
    <div class="content__header">
        <h2>支払方法選択</h2>
    </div>
    <div class="content__form">
        <form action="/change/method/{{$item_id}}" method="post" class="chage__form">
            @csrf
            <select name="paymethod" id="" class="form__content-input">
                <option value="" class="select__button">支払方法を選択してください</option>
                <option value="credit" class="select__button">クレジットカード</option>
                <option value="konbini" class="select__button">コンビニ払い</option>
                <option value="bank_transfer" class="select__button">銀行振込</option>
            </select>
            <input type="hidden" name="item_id" value="{{$item_id}}">
            <div class="change__button">
                <button class="change__method">変更する</button>
            </div>
            <div class="back__link">
                <a href="/buy/{{$item_id}}" class="back__link-a">戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection