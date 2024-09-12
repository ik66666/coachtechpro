@extends('layouts.app2')

@section('title')
コメントページ
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/comment.css') }}">
@endsection

@section('content')
@if (session('success'))
        <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif
<div class="comment__content">
    <div class="item__image">
        <img src="{{ asset('storage/images/' . $items->image_url) }}" class="item__image-file">
    </div>
    <div class="item__detail">
        <div class="item__name">
            <span class="item__name-value">{{$items->name}}</span>
        </div>
        <div class="item__price">
            <span class="item__price-value">¥{{ number_format($items->price)}}(値段)</span>
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
        <div class="comment__list">
            @foreach($comments as $comment)
                <div class="comment__list-item">
                    <span class="comment__user">{{ $comment->users_id}}</span>
                    <div class="comment-detail">
                        {{$comment->comment}}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="comment__field">
            <form action="/comment/{{$items->id}}" method="post" class="comment__form">
                @csrf
                <input type="hidden" name="item_id" value="{{$items->id}}">
                <input type="hidden" name="users_id" value="{{Auth::id()}}">
                <label for="" class="comment__form-label">商品へのコメント</label>
                <textarea name="comment" class="comment__form-item"></textarea>
                <div class="error__message">
                    @error('comment')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form__button">
                    <button type="submit" class="form__button-btn">
                        コメントを送信する
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
    
@endsection