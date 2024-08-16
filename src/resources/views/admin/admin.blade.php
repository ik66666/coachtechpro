<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <title>
    管理者画面
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
        <div class="admin__content">
            <div class="admin__header">
                <h2 class="admin__header-title">管理画面</h2>
            </div>
            <div class="user__list">
                <table>
                    <div class="user__list-header">
                        <th class="user__list-header-title">ID</th>
                        <th class="user__list-header-title">email</th>
                        <th class="user__list-header-title">コメント</th>
                        <th class="user__list-header-title"></th>
                    </div>
                    @foreach($users as $user)
                        <div class="user__list-item">
                            <tr class="user__list-item-raw">
                                <td class="item__detail">{{ $user->id}}</td>
                                <td class="item__detail">{{ $user->email}}</td>
                                <td class="item__detail">
                                    <a href="/admin/{{ $user->id }}" class="item__detail-a">コメント一覧</a>
                                </td>
                                <td class="item__detail">
                                    <form action="/admin/delete/{{ $user->id }}" method="post" class="form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="user__delete-button">ユーザー削除</button>
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