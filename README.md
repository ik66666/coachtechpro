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

#### 4. 使用技術

このプロジェクトでは、以下の技術スタックを使用しています。

- **Webサーバ**: Nginx (バージョン 1.21.1)
  - 使用ポート: 80
  - 設定ファイル: `./docker/nginx/default.conf`
  
- **アプリケーション**: PHP
  - 使用イメージ: カスタムビルド (`./docker/php`)
  - コードベース: `./src`ディレクトリ
  
- **データベース**: MySQL (バージョン 8.0.30)
  - データベース名: `laravel_db`
  - ユーザー: `laravel_user`
  - パスワード: `laravel_pass`
  - ボリューム: `./docker/mysql/data` (データ保存先)
  - 設定ファイル: `./docker/mysql/my.cnf`
  
- **データベース管理ツール**: phpMyAdmin
  - 使用ポート: 8080
  - ホスト: MySQLコンテナ (`mysql`)
  - 認証情報: `laravel_user` / `laravel_pass`
  
- **メールサーバ**: Mailhog
  - 使用ポート: 8025
  - メール保存: `maildir`
  - ボリューム: `/tmp` (メール保存先)

- **AWS CloudFormation**: EC2インスタンスやVPCの作成に使用
  - AMI ID: `ami-06aa91d03bbe9eed7` (Amazon Linux 2)
  - インスタンスタイプ: `t2.micro`（デフォルト）
  - SSHアクセス: EC2 KeyPair `laravel-ci-ec2-user`
  - VPCおよびサブネット: `172.18.0.0/16` (VPC CIDR)
  - セキュリティグループ: ポート `22`, `80`, `443` 開放


## 2.開発環境構築方法

#### 1.リポジトリのクローン
リポジトリをクローンします。
```
git clone git@github.com:ik66666/coachtechpro.git
cd [プロジェクト名]
```

#### 2.docker-compose コマンドでビルド

以下のコマンドで開発環境を構築
```
docker-compose up -d --build

```
PHP、MySQL、Nginx、PHPMyAdmin、mailhogが起動すれば成功

#### 3.依存パッケージのインストール

PHPコンテナにログインし、以下のコマンドでパッケージをインストール

```
docker-compose exec php bash
composer install

```

## 3.envファイルの設定

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
テスト用の.env.testingファイルと自動テスト用の.env.exampleファイルも適宜作成・修正してください
```
APP_NAME=Laravel
APP_ENV=test
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost
// 中略
DB_CONNECTION=mysql_test
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=demo_test
DB_USERNAME=root
DB_PASSWORD=root

```
各ファイルのアプリケーションキーの生成
```
php artisan key:generate

```

## 4. テスト方法

このプロジェクトにはFeatureテストが含まれています。Featureテストのみを実行するには、以下のコマンドを使用します。

1. PHPコンテナにログインしFeatureテストの実行
```
   docker-compose exec php bash
   ./vendor/bin/phpunit --testsuite=Feature
```

## 5. 自動テストとデプロイ

### 5.1. 自動テスト
このプロジェクトでは、CircleCIを使用してプッシュ時に自動でテストが実行されます。

1. プロジェクトに変更を加えた後、リポジトリにプッシュすると、自動的にCircleCIが起動し、テストが実行されます。
2. CircleCIの設定は、`.circleci/config.yml`ファイルに記載されています。
3. 成功した場合、テスト結果はCircleCIのダッシュボードから確認できます。

### 5.2. 自動デプロイ
CircleCIを使用して、AWS EC2に自動でデプロイが行われます。

1. `main`ブランチにマージすると、CircleCIがトリガーされ、自動的にデプロイが開始されます。
2. AWS EC2インスタンスには、CloudFormationを使用して構築された環境にデプロイされます。
3. デプロイの詳細は、CircleCIのログまたはAWS管理コンソールで確認できます。

環境設定や手動でのデプロイが必要な場合は、`.circleci/config.yml`を参照してください。


## その他特記事項

#### 1.ユーザー認証機能はfortifyを使用
PHPコンテナ内にてfortifyをインストールし、マイグレーションの作成

```
docker-compose exec php bash
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
/adminは管理者画面用、
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
