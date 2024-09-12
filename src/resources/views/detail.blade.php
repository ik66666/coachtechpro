@extends('layouts.app2')

@section('title')
商品詳細画面
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail__content">
    <div class="item__image">
        <img src="{{ asset('storage/images/' . $items->image_url) }}" class="item__image-file">
    </div>
    <div class="item__detail">
        <div class="item__name">
            <span class="item__name-value">{{$items->name}}</span>
        </div>
        <div class="item__price">
            <span class="item__price-value">¥{{number_format($items->price)}}(値段)</span>
        </div>
        <div class="item__link">
            <div class="item__like">
                @if ($likes)
                    <form action="/favorite/{{ $items->id }}" method="POST" class="form__like" >
                    <input type="hidden" name="item_id" value="{{$items->id}}">
                    <input type="hidden" name="users_id" value="{{Auth::id()}}">
                    @csrf
                    @method('DELETE')
                    <div class="likes">
                        <input type="image" src="/images/star.png" class="like__button">
                        <span class="likes_count">{{ $likeCount }}</span>
                    </div>
                    </form>
                @else
                    <form action="/favorite/{{ $items->id }}" method="POST" class="form__like" >
                    <input type="hidden" name="item_id" value="{{$items->id}}">
                    <input type="hidden" name="users_id" value="{{Auth::id()}}">
                    @csrf
                    <div class="likes">
                        <input type="image" src="/images/star.png" class="like__button">
                        <span class="likes_count">{{ $likeCount }}</span>
                    </div>
                    </form>

                @endif
                <div class="item__comment">
                    <a href="/comment/{{$items->id}}" class="comment__button">
                    <img src="/images/comment.png" alt="" class="comment__image">
                    </a>
                    <span class="comment_count">{{ $CommentCount }}</span>
                </div>
            </div>
        </div>
        <div class="item__buy">
            <button class="item__buy-button">
                <a href="/perchase/{{$items->id}}" class="item__buy-link">購入する</a>
            </button>
        </div>
        <span class="item__description-title">商品説明</span>
        <div class="item__description">
            {{ $items->description}}
        </div>
        <div class="item__info">
            <span class="item__info-title">商品情報</span>
            <div class="item__category">
                <span class="item__category-title">カテゴリー</span>
                @isset($category_item)
                <div class="item__category-value">
                    {{ $category_item->category->name }}
                </div>
                @endisset
                
            </div>
            <div class="item__condition">
                <span class="item__condition-title">商品の状態</span>
                {{$items->condition->condition}}
            </div>
        </div>
    </div>
</div>
@endsection