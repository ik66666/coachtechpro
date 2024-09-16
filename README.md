## 1.プロダクト概要

#### 1.プロダクト名

coachtechフリマ

#### 2.プロダクトの目的

coachtechブランドのアイテムを出品する

#### 3.プロダクトの設計書

下記リンクのスプレッドシートにプロダクト詳細記載
- ページ一覧
- 機能一覧
- テーブル設計書
- 基本設計書
- ER図
- https://docs.google.com/spreadsheets/d/1TBjWt6wV2KDjiLHLZxxmBXTdWIpoOQOtQF-MfLJrZPo/edit?usp=sharing

## 2.開発環境構築方法

#### 1. Docker  のインストール
※Windows（Linux環境）での開発を想定してます。
 docker desktopを下記リンクよりインストールしてください。
- https://www.docker.com/products/docker-desktop/
- インストール方法は公式ドキュメントを参照してください。

#### 2.ディレクトリの作成

任意のディレクトリに下記構成のディレクトリを作成
```
.
├── docker
│   ├── mysql
│   │   ├── data
│   │   └── my.cnf
│   ├── nginx
│   │   └── default.conf
│   └── php
│       ├── Dockerfile
│       └── php.ini
├── docker-compose.yml
└── src
```
#### 3. Docker Compose ファイルの設定

```
version: '3.8'

volumes:
    maildir: {}

services:
    nginx:
        image: nginx:1.21.1
        ports:
            - "80:80"
        volumes:
            - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
            - ./src:/var/www/
        depends_on:
            - php

    php:
        build: ./docker/php
        volumes:
            - ./src:/var/www/

    mysql:
        image: mysql:8.0.30
        environment:
            MYSQL_ROOT_PASSWORD: root
            MYSQL_DATABASE: laravel_db
            MYSQL_USER: laravel_user
            MYSQL_PASSWORD: laravel_pass
        command:
            mysqld --default-authentication-plugin=mysql_native_password
        volumes:
            - ./docker/mysql/data:/var/lib/mysql
            - ./docker/mysql/my.cnf:/etc/mysql/conf.d/my.cnf

    phpmyadmin:
        image: phpmyadmin/phpmyadmin
        environment:
            - PMA_ARBITRARY=1
            - PMA_HOST=mysql
            - PMA_USER=laravel_user
            - PMA_PASSWORD=laravel_pass
        depends_on:
            - mysql
        ports:
            - 8080:80

    mail:
        image: mailhog/mailhog
        container_name: mailhog
        ports:
            - "8025:8025"
        environment:
            MH_STORAGE: maildir
            MH_MAILDIR_PATH: /tmp
        volumes:
            - maildir:/tmp

```

#### 4.Nginx の設定

./docker/nginx/conf.d/default.conf を作成し、以下の内容を追加します。

```
server {
    listen 80;
    index index.php index.html;
    server_name localhost;

    root /var/www/public;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
}
```

#### 5.PHPの設定
./docker/phpに作成されたDockerfileに以下内容を追加

```
FROM php:7.4.9-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
    && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

WORKDIR /var/www

```

docker/php以下のphp.iniファイルに以下内容を追加

```
date.timezone = "Asia/Tokyo"

[mbstring]
mbstring.internal_encoding = "UTF-8"
mbstring.language = "Japanese"
```

#### 6.MySQLの設定

docker/mysql以下のmy.cnfファイルに以下内容を追加

```
[mysqld]
character-set-server = utf8mb4

collation-server = utf8mb4_unicode_ci

default-time-zone = 'Asia/Tokyo'
```
※dataフォルダは必ず空にしておく

#### 7.docker-compose コマンドでビルド

以下のコマンドで開発環境を構築
```
docker-compose up -d --build

```
PHP、MySQL、Nginx、PHPMyAdmin、mailhogが起動すれば成功

#### 8.laravelプロジェクトの作成

PHPコンテナにログインし、以下のコマンドでプロジェクトを作成

```
docker-compose exec php bash
composer create-project "laravel/laravel=8.*" . --prefer-dist
```
#### .envファイルの設定

下記環境変数を参照して.envファイルを作成
```
// 中略
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
// 中略
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=test@test.com
MAIL_FROM_NAME="${APP_NAME}"
// 中略
STRIPE_KEY="所有するStripeアカウントの公開可能キー"
STRIPE_SECRET="所有するStripeアカウントのシークレットキー"

```
下記環境変数を参照しテスト用の.env.testingファイルを作成
```
// 中略
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=demo_test
DB_USERNAME=root
DB_PASSWORD=root
// 中略
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=test@test.com
MAIL_FROM_NAME="${APP_NAME}"
// 中略
STRIPE_KEY="所有するStripeアカウントの公開可能キー"
STRIPE_SECRET="所有するStripeアカウントのシークレットキー"

```


## その他特記事項

#### 1.ユーザー認証機能はfortifyを使用
PHPコンテナ内にてfortifyをインストールし、マイグレーションの作成

```
composer require laravel/fortify
php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
php artisan migrate
```
app.phpの修正
config/app.phpファイルの以下２点を編集
80行目のローケルの変更
```
'locale' => 'ja',
```
137行目にサービスプロバイダーの追加
```
'providers' => [
// 中略
  App\Providers\RouteServiceProvider::class,
+ App\Providers\FortifyServiceProvider::class,
]
```
app/Providers/ディレクトリ以下にあるFortifyServiceProvider.phpのbootメソッドの修正

```
public function boot(): void
    {

        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

    }
```
app/Providers/RouteServiceProvider.phpの HOME を修正

```
- public const HOME = '/dashboard';
+ public const HOME = '/';
+ public const ADMIN_HOME = '/admin';

```
PHPコンテナ内で日本語ファイルをインストール
```
composer require laravel-lang/lang:~7.0 --dev
cp -r ./vendor/laravel-lang/lang/src/ja ./resources/lang/
```
#### 2.決済機能はStripeのテスト環境を使用

Stripeアカウントを公式サイトにて作成しAPIキーを取得
StripePHPライブラリのインストール
```
composer require stripe/stripe-php

```
.envファイルと.env.testingに環境変数を設定
```
STRIPE_KEY="公開可能キー"
STRIPE_SECRET="シークレットキー"
```