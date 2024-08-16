@extends('layouts.app')

@section('title')
ログイン
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__content">
    <div class="login__content-header">
        <h2 class="login__content-header-title">管理者ログイン</h2>
    </div>
    <div class="login__form">
        <form action="/admin/login_form" method="post" class="form">
            @csrf
            <div class="form__content">
                <div class="form__content-title">
                    <span class="form__title">メールアドレス</span>
                </div>
                <div class="form__content-text">
                    <input type="email" name="email" value="{{ old('email') }}" class="form__text">
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
                    <input type="password" name="password" class="form__text">
                </div>
                <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="login__button">
                <button class="login__button-btn">ログインする</button>
            </div>
        </form>
    </div>
    
</div>
@endsection