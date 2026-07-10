# CorpAdmin



# 構築手順

## 1. dev イメージをビルド
docker compose build app

## 2. Laravel 13 を scaffold（このディレクトリに生成される）
docker compose run --rm app composer create-project laravel/laravel:^13.0 . --no-interaction

## 3. Livewire 4 を導入
docker compose run --rm app composer require "livewire/livewire:^4.0"

# ここまでで composer.json / package.json がフォルダに生成されている

## 4. あらためて runtime をビルド
docker build --target runtime -t employee-app:prod .

※詳細は、SETUP.md参照
