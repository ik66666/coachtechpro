<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <title>
    ユーザーコメント一覧
    </title>
</head>
<body>
    <header class="header">
        <div class="header__content">
            <a href="" class="header__logo">
                <img src="{{ 'images/logo.svg'}}" class="header__logo-image" alt="">
            </a>
            <a href="/admin" class="nav__item-a">
                    <button class="nav__item-button">管理画面</button>
            </a>
        </div>
    </header>
    <main>
        <div class="admin__content">
            <div class="admin__header">
                <h2 class="admin__header-title">コメント一覧</h2>
            </div>
            <div class="user__list">
                <table>
                    <div class="user__list-header">
                        <th class="user__list-header-title">商品名</th>
                        <th class="user__list-header-title">コメント内容</th>
                        <th class="user__list-header-title">コメント日時</th>
                        <th class="user__list-header-title"></th>
                    </div>
                    @foreach($comments as $comment)
                        <div class="user__list-item">
                            <tr class="user__list-item-raw">
                                <td class="item__detail">{{ $comment->item->name}}</td>
                                <td class="item__detail">{{ $comment->comment}}</td>
                                <td class="item__detail">{{ $comment->created_at}}</td>
                                <td class="item__detail">
                                    <form action="/comment/delete/{{ $comment->id }}" method="post" class="form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="user__delete-button">コメント削除</button>
                                    </form>
                                </td>
                            </tr>
                        </div>
                    @endforeach
                </table>
            </div>
        </div>
    </main>
</body>
</html>