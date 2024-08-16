@extends('layouts.app2')

@section('title')
プロフィール編集画面
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}
">
@endsection

@section('content')
<div class="profile__content">
    <div class="profile__header">
        <h2 class="header__title">プロフィール設定</h2>
    </div>
    <div class="profile__form">
        <form method="post" action="/mypage/edit-profile" class="form" enctype="multipart/form-data">
            @csrf
            <div class="form__image">
                <span class="form__image">
                    <label for="avatar" class="form__image-item">
                    <img src="/images/avatar-default.png" class="rounded-circle" style="object-fit: cover; width: 150px; height: 150px;">
                    </label>
                    <input type="file" name="image_url"  class="fomr__image" value="画像を選択する" accept="image/png,image/jpeg,image/gif" />
                </span>
            </div>
            <div class="form__item">
                <label for="name">ユーザー名</label>
                <input type="text" class="form__item-content"  name="name" value="{{ old('name')}}" >
                @error('name')
                <span class="error__message" >
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form__item">
                <label for="name">郵便番号</label>
                <input type="text" class="form__item-content"  name="postcode" value="{{ old('postcode')}}" >
                @error('postcode')
                <span class="error__message">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form__item">
                <label for="name">住所</label>
                <input type="text" class="form__item-content"  name="address" value="{{ old('address')}}" >
                @error('address')
                <span class="error__message">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form__item">
                <label for="name">建物名</label>
                <input type="text" class="form__item-content"  name="building" value="{{ old('building')}}" >
                @error('building')
                <span class="error__message">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form__button">
                <button type="submit" class="form__button-btn">更新する</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection