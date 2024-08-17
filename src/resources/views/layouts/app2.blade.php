<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/common2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <title>
    @yield('title')
    </title>
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__content">
            <a href="/" class="header__logo">
                <img src="/images/logo.svg" class="header__logo-image" alt="">
            </a>
        </div>
        <div class="search__form">
            <form action="/" method="post" class="form">
                @csrf
                <input type="text" name="keyword" placeholder="なにをお探しですか？" class="form__search">
            </form>
        </div>
        <ul class="header__nav">
            @if (Auth::check())
            <form action="/logout" method="post" >
                @csrf
            <li class="header__nav-item">
                <button class="logout__button">ログアウト</button>
            </li>
            </form>
            <li class="header__nav-item">
                <a href="{{ route('mypage.home')}}" class="mypage__link">マイページ</a>
            </li>
            
            @else
            <li class="header__nav-item">
                <a class="header__nav-link" href="/login">ログイン</a>
            </li>
            <li class="header__nav-item">
                <a class="header__nav-link" href="/register">会員登録</a>
            </li>
            @endif
            <li>
                <a href="/sell" class="nav__item-a">
                    <button class="nav__item-button">出品</button>
                </a>
            </li>
        </ul>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>