@extends('layouts.app')

@section('title')
出品ページ
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css')}}">
@endsection

@section('content')
<div class="sell__content">
    <div class="content__header">
        <h2 class="content__header-tile">商品の出品</h2>
    </div>
    <div class="sell__form">
        <form action="/sell" method="post" class="form" enctype="multipart/form-data">
            @csrf
            <div class="content__image">
                <label  class="content__detail-image">商品画像</label>
                <div class="content__image-item">
                    <label for="image_url" class="file__label">
                        <input type="file" name="image_url" id="image_url" class="form__image"  accept="image/png,image/jpeg,image/gif" />
                        <span>画像を選択する</span>
                    </label>
                </div>
                @error('image')
                    <span class="error__message" >
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="content__item-detail">
                <h3 class="detail__text">商品の詳細</h3>
            </div>
            <div class="content__detail">
                <label for="category" class="content__detail-title">カテゴリー</label>
                <select name="categories"  class="content__detail-select">
                    @foreach( $categories as $category)
                        <option value="{{ $category->id}}" >{{ $category->name}}</option>
                    @endforeach
                </select>
                    @error('category')
                        <span class="error__message" >
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
            <div class="content__detail">
                <label for="iamge_url" class="content__detail-title">商品の状態</label>
                <select name="condition"  class="content__detail-select">
                    @foreach( $conditions as $condition)
                        <option value="{{ $condition->id}}" >{{ $condition->condition}}</option>
                    @endforeach
                </select>
                <div class="form__error">
                    @error('condition')
                    <span class="error__message" >
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="content__item-detail">
                <h3 class="detail__text">商品名と説明</h3>
            </div>
            <div class="content__detail">
                <label for="name" class="content__detail-title">商品名</label>
                <input type="text" name="name" value="{{ old('name') }}"class="content__detail-input">
                <div class="form__error">
                    @error('name')
                    <span class="error__message" >
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="content__detail">
                <span class="content__detail-title">商品の説明</span>
                <textarea name="description" value="{{ old('description') }}"class="content__detail-description"></textarea>
                <div class="form__error">
                    @error('description')
                    <span class="error__message" >
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="content__item-detail">
                <h3 class="detail__text">販売価格</h3>
            </div>
            <div class="content__detail">
                <label for="price" class="content__detail-title">販売価格</label>
                <input type="number" name="price" placeholder="¥" value="{{ old('name') }}"class="content__detail-input">
                <div class="form__error">
                    @error('price')
                    <span class="error__message" >
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-btn">出品する</button>
            </div>
        </form>
    </div>
</div>
@endsection