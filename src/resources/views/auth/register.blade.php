@extends('layouts.app')

@section('title')
会員登録
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="regiter__content">
    <div class="register__title">
        <h2 class="register__title-h2">会員登録</h2>
    </div>
    <div class="register__form">
        <form class="form" action="/register" method="post">
            @csrf
            <div class="form__content">
                <div class="form__content-title">
                    <span class="form__title">メールアドレス</span>
                </div>
                <div class="form__content-text">
                    <input type="email" name="email"  value="{{ old('email') }}" class="form__content-item" />
                </div>
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__content">
                <div class="form__content-title">
                    <span class="form__title">パスワード</span>
                </div>
                <div class="form__content-text">
                    <input type="password" name="password"  class="form__content-item" />
                </div>
                <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__content">
                <div class="form__content-title">
                    <span class="form__title">確認用パスワード</span>
                </div>
                <div class="form__content-text">
                    <input type="password" name="password_confirmation"  class="form__content-item" />
                </div>
                <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-btn">登録する</button>
            </div>
        </form>
        <div class="login__link">
            <a href="/login" class="login__link-button">ログインはこちら</a>
        </div>
    </div>
</div>
@endsection
