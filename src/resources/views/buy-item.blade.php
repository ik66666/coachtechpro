@extends('layouts.app2')

@section('title')
マイページ
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage__content">
    <div class="profile__content">
        <div class="profile__image">
            <span class="avatar-form image-picker">
                <label for="avatar" class="profile__image-item">
                    <img src="/images/avatar-default.png" class="image__item" style="object-fit: cover; width: 150px; height: 150px;">
                </label>
            </span>
        </div>
        <div class="profile__user">
            <span class="profile__user-name">ユーザー名</span>
        </div>
        <div class="profile__edit">
            <button class="profile__edit-button">
                <a href="/mypage/profile" class="edit__link">プロフィールを編集</a>
            </button>
        </div>
    </div>
    <div class="mypage__item">
        <a href="/mypage" class="sell__item">出品した商品</a>
        <a href="/mypage/buy" class="perchase__item">購入した商品</a>
    </div> 
    <div class="sell_content">
        @foreach($items as $item)
            <div class="sell__item-content">
                <img src="{{ asset('storage/images/' . $item->image_url) }}" class="item__image-file">
                <div class="content__name">{{ $item->item->name}}</div>
                <a href="/detail/{{ $item->id }}" class="card__link"></a>
            </div>
        @endforeach
    </div>
</div>
@endsection