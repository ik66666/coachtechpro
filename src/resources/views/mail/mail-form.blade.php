<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/mail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <title>
    メール送信フォーム
    </title>
</head>
<body>
    <header class="header">
        <div class="header__content">
            <a href="" class="header__logo">
                <img src="{{ 'images/logo.svg'}}" class="header__logo-image" alt="">
            </a>
        </div>
    </header>
    <main>
        <div class="admin__header">
            <h2 class="admin__header-title">メール送信</h2>
        </div>
        <div class="form__content">
            <form action="{{ $user->id }}" method='POST'>
                @csrf
                <div class="form-group">

                    <h3>メッセージ</h3>
                    <input type="text" name="message" value="{{ old('message') }}" class="form__control">
                    @if ($errors->has('message'))
                    <p class="bg-danger">{{ $errors('message') }}</p>
                    @endif
                    <input type="hidden" name="user" value="{{ $user->id }}" >
                    <div class="button">
                        <button type="submit" class="btn ">送信</button>
                    </div>
                </div>
                <div class="back__link">
                    <a href="/admin" class="back__link-a">戻る</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>


