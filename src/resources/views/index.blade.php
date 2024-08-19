@extends('layouts.app2')

@section('title')
トップページ
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
    @if (session('success'))
        <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif
    <div class="content__title">
        <a href="/" class="title">おすすめ</a>
        <a href="/my-favorite" class="title">マイリスト</a>
    </div>
    <div class="item__raw">
        @foreach( $items as $item)
            <div class="item__card">
                    <img src="{{ asset('storage/images/' . $item->image_url) }}" class="item__image-file">
                    <p class="card__price">¥{{number_format($item->price)}}</p>
                    <p class="card__title">{{$item->name}}</p>
                    <a href="/detail/{{ $item->id }}" class="card__link"></a>
            </div>
        @endforeach
    </div>

     <div class="paginate__link">
         {{ $items->withQueryString()->links() }}
     </div>
</div>
@endsection