# 環境構築

## Dockerビルド

```bash
$ git clone git@github.com:yukit4mu/pigly.git
$ cd pigly
$ docker-compose up -d --build
```

## Laravel環境構築

```bash
$ docker-compose exec php bash
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed
```

## 開発環境

- トップページ（管理画面）：http://localhost/weight_logs
- 体重登録：http://localhost/weight_logs/create
- 体重検索：http://localhost/weight_logs/search
- 体重詳細：http://localhost/weight_logs/{weightLogId}
- 体重更新：http://localhost/weight_logs/{weightLogId}/update
- 体重削除：http://localhost/weight_logs/{weightLogId}/delete
- 目標体重設定：http://localhost/weight_logs/goal_setting
- 会員登録（Step1）：http://localhost/register/step1
- 初期目標体重登録（Step2）：http://localhost/register/step2
- ログイン：http://localhost/login
- ログアウト：http://localhost/logout
- 
## 使用技術（実行環境）

- PHP 8.2.11
- Laravel 8.83.8
- jquery 3.7.1.min.js
- MySQL 8.0.26
- nginx 1.21.1

## ER図


