@extends('layouts.app2')

@section('title')
住所変更ページ
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address__content">
    <div class="content__title">
        <h1 class="address_title">住所の変更</h1>
    </div>
    <div class="address__form">
        <form action="/address" method="POST" class="form">
            @csrf
            <div class="form__content">
                <label for="" class="form__content-title">郵便番号</label>
                <input type="text" name="postcode" value="{{ old('postcode') }}"class="form__content-input">
                <div class="error__massage">
                    @error('postcode')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__content">
                <label for="" class="form__content-title">住所</label>
                <input type="text" name="address" value="{{ old('address') }}"class="form__content-input">
                <div class="error__massage">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__content">
                <label for="" class="form__content-title">建物名</label>
                <input type="text" name="building" value="{{ old('building') }}"class="form__content-input">
                <div class="error__massage">
                    @error('building')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__button">
                <button type="submit" class="update__button">更新する</button>
            </div>
            <div class="back__link">
                <a href="javascript:history.back()" class="back__link-a">戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection