# syntax=docker/dockerfile:1
#
# 社員管理アプリ用 マルチステージ Dockerfile
#   Laravel 13 / Livewire 4(最新) / PHP 8.4(既定) / MySQL 8.4
#
# ステージ構成（役割ごとに分ける = マルチステージの本質）:
#   base    … 全ステージ共通の PHP-FPM + 拡張 + 設定
#   dev     … 開発用（composer / git を同梱、ソースはbind mount）
#   vendor  … Composer 依存だけを解決する使い捨てステージ
#   assets  … Vite/Tailwind で JS/CSS をビルドする使い捨てステージ
#   runtime … 本番用。vendor と assets の成果物だけを取り込む軽量イメージ
#
# バージョンは ARG で一元管理。8.5 に上げたいときはビルド時に
#   docker build --build-arg PHP_VERSION=8.5 ...
# とするだけ（Dockerfile 本文を触らない）。

ARG PHP_VERSION=8.4
ARG NODE_VERSION=22
ARG COMPOSER_VERSION=2

########################################
# Stage: composer_bin（Composer本体だけを取り出すための踏み台ステージ）
########################################
# COPY --from に「変数展開したイメージ参照」は使えない（BuildKitの制約）。
# FROM 行なら ARG 展開が効くので、いったんステージ化してから
# 他ステージは "COPY --from=composer_bin" のようにステージ名で参照する。
FROM composer:${COMPOSER_VERSION} AS composer_bin

########################################
# Stage: base（共通土台）
########################################
FROM php:${PHP_VERSION}-fpm-bookworm AS base

# 拡張は mlocati のヘルパで導入する。
# docker-php-ext-configure を手書きするより、依存ライブラリの解決を任せられて堅牢。
COPY --from=mlocati/php-extension-installer:latest \
     /usr/bin/install-php-extensions /usr/local/bin/

# Laravel + MySQL + 画像/ファイルアップロードに必要な拡張一式
RUN install-php-extensions \
      pdo_mysql \
      mbstring \
      bcmath \
      intl \
      zip \
      exif \
      pcntl \
      gd \
      opcache

# 本番寄りの php.ini（opcache 等）。dev では validate_timestamps を上書きする。
COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-app.ini

WORKDIR /var/www/html

########################################
# Stage: dev（開発用）
########################################
# ソースコードは COPY しない。docker-compose 側で bind mount するため、
# ここには「開発中にコンテナ内で叩きたいツール」だけ入れる。
FROM base AS dev

RUN apt-get update \
 && apt-get install -y --no-install-recommends git unzip default-mysql-client \
 && rm -rf /var/lib/apt/lists/*

# Composer 本体を composer_bin ステージからコピー（composer install / require をコンテナ内で実行するため）
COPY --from=composer_bin /usr/bin/composer /usr/local/bin/composer

# 開発時はソース変更を即反映したいので opcache のタイムスタンプ検証を有効化
RUN echo "opcache.validate_timestamps=1" > /usr/local/etc/php/conf.d/zzz-dev.ini

# php-fpm の既定 CMD をそのまま使う（compose から nginx がぶら下がる）

########################################
# Stage: vendor（Composer 依存の解決 / 使い捨て）
########################################
FROM composer:${COMPOSER_VERSION} AS vendor
WORKDIR /app

# まず依存定義だけコピー → ここが変わらない限りビルドキャッシュが効く
COPY composer.json composer.lock ./
RUN composer install \
      --no-dev \
      --no-scripts \
      --no-autoloader \
      --prefer-dist \
      --no-interaction \
      --no-progress

# アプリ本体をコピーしてから、本番最適化オートローダを生成
COPY . .
RUN composer dump-autoload --no-dev --optimize

########################################
# Stage: assets（フロントエンドビルド / 使い捨て）
########################################
FROM node:${NODE_VERSION}-bookworm-slim AS assets
WORKDIR /app

# lockfile 基準で厳密インストール（再現性のため install ではなく ci）
COPY package.json package-lock.json ./
RUN npm ci

# Tailwind の設定形式は v3(tailwind.config.js) と v4(CSSベース) で異なる。
# 設定ファイルを個別 COPY すると構成差で壊れるため、ソース一式を渡すのが堅牢。
# （node_modules は .dockerignore で除外済み）
COPY . .
RUN npm run build

########################################
# Stage: runtime（本番イメージ）
########################################
FROM base AS runtime

# アプリ本体 → vendor → ビルド済みアセット の順に重ねる
COPY . .
COPY --from=vendor  /app/vendor        ./vendor
COPY --from=assets  /app/public/build  ./public/build

# storage / bootstrap-cache を www-data が書き込めるように
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R ug+rwX storage bootstrap/cache

# php-fpm は www-data で動くのでプロセスユーザも合わせる
USER www-data

# ヘルスチェック用に php-fpm の待受ポート
EXPOSE 9000