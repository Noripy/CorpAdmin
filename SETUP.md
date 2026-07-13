# 社員管理アプリ 環境構築手順（Laravel 13 / Livewire 4 / MySQL 8.4）

> 詰まったら先に [`TROUBLESHOOTING.md`](./TROUBLESHOOTING.md) を検索すること。実際に遭遇した罠と対処をまとめてある。

## 前提の順序（ここが唯一のハマりどころ）

`runtime` ステージは `composer.json` などアプリ本体を `COPY` する。
つまり **Laravel をまだ scaffold していない空ディレクトリでは runtime ビルドは通らない**。
なので順序はこう:

1. Docker 関連ファイル（この一式）を空ディレクトリに置く
2. **dev コンテナで Laravel を scaffold する**（アプリ本体を生成）
3. Livewire を入れる
4. 以後、開発 or 本番ビルド

---

## 手順

### 1. dev イメージをビルド
```bash
docker compose build app
```

### 2. Laravel 13 を scaffold（このディレクトリに生成）

このフォルダには既に Docker 関連ファイルが置かれているため、
素の `composer create-project laravel/laravel:^13.0 .` は
**`Project directory "/var/www/html/." is not empty.` で失敗する**
（Composer は対象ディレクトリが空でないと create-project を拒否する仕様）。

コンテナ内の一時ディレクトリに scaffold してから、既存の `.gitignore`（Docker/Livewire向けに手を加えたもの）
を上書きしないよう退避しつつ、現在地にマージする:

```bash
docker compose run --rm app sh -c '
  set -e
  TMP=$(mktemp -d)
  composer create-project laravel/laravel:^13.0 "$TMP" --no-interaction
  cp .gitignore /tmp/gitignore.bak
  cp -a "$TMP"/. .
  cp /tmp/gitignore.bak .gitignore
  rm -rf "$TMP" /tmp/gitignore.bak
'
```

`/tmp` はコンテナ内だけの領域（bind mount されているのは `/var/www/html` のみ）なので、
一連の処理を **1回のコンテナ実行内で完結させる**必要がある（分割すると `--rm` でコンテナごと消える）。

実行後の確認:
```bash
ls -la              # composer.json / app/ / public/ などが生成されているか
cat .gitignore | head -5   # 自作の.gitignoreが上書きされていないか
```

### 3. Livewire 4 を導入
```bash
docker compose run --rm app composer require "livewire/livewire:^4.0"
```

Livewire 4 は `make:livewire` のデフォルトが **Single-File Components(SFC)**（PHPクラスとBladeを1ファイルに統合、`⚡`プレフィックス）に変わった。
今回は **class-base（PHP/Bladeを分離する旧来形式）を既定に固定する**。

`config/livewire.php` を公開して既定を変更する:
```bash
docker compose run --rm app php artisan livewire:publish --config
```
生成された `config/livewire.php` 内の `component_type` を書き換える:
```php
'component_type' => 'class', // 既定の 'sfc' から変更
```

フルページコンポーネント（ルートに直接紐づくもの）を使うなら、レイアウトの雛形も生成しておく:
```bash
docker compose run --rm app php artisan livewire:layout
```

> 個々のコンポーネントだけ一時的にSFCで試したい場合は、config を変えずに
> `php artisan make:livewire Foo --sfc` のようにコマンド側で指定すれば都度切り替えられる。

### 4. `.env` を用意する（Docker Compose 用の認証情報）

```bash
cp .env.example .env
```

### 5. 起動 → キー生成 → マイグレーション
```bash
docker compose up -d
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

ブラウザで http://localhost:8080 を開けば Laravel の初期画面が出る。

### 6. 最初の Livewire コンポーネントを作る例
```bash
docker compose exec app php artisan make:livewire EmployeeList
# config/livewire.php で component_type を class に固定していれば、
# app/Livewire/EmployeeList.php + resources/views/livewire/employee-list.blade.php が生成される
```

フルページコンポーネントとしてルートに紐づける場合、Livewire 4 では `Route::livewire()` を使う:
```php
// routes/web.php
Route::livewire('/employees', EmployeeList::class);
```

---

## 日々のコマンド

| やりたいこと | コマンド |
|---|---|
| 起動 / 停止 | `docker compose up -d` / `docker compose down` |
| artisan | `docker compose exec app php artisan <cmd>` |
| composer | `docker compose exec app composer <cmd>` |
| フロントのHMR | `vite` サービスが自動起動（http://localhost:5173） |
| DBに直接入る | `docker compose exec db mysql -uapp -psecret employee` |
| ログ確認 | `docker compose logs -f app` |

---

## トラブルシューティング

実際に遭遇したエラーと対処は [`TROUBLESHOOTING.md`](./TROUBLESHOOTING.md) にまとめてある。
詰まったらまずそちらを検索すること。

---

## 本番相当イメージの検証（compose を使わず単体ビルド）

```bash
docker build --target runtime -t employee-app:prod .
# 8.5 で試すなら:
docker build --target runtime --build-arg PHP_VERSION=8.5 -t employee-app:prod-85 .
```

`runtime` は vendor(--no-dev) とビルド済みアセットだけを含む軽量・不変イメージ。
本番/ステージングはこれをそのまま流す想定。

---

## 動作確認チェックリスト（納品前に自分で叩く）

- [ ] `.env.example` を `.env` にコピー済み（無いと `docker compose up` が `:?` エラーで停止する）
- [ ] `docker compose build app` がエラーなく完走する
- [ ] `docker compose up -d` 後、`docker compose ps` で db が healthy になる
- [ ] http://localhost:8080 で Laravel 画面が表示される
- [ ] `php artisan migrate` が成功する（= app→db 接続が通っている）
- [ ] 適当な Livewire コンポーネントを表示し、`wire:model` の双方向が効く
- [ ] `make:livewire` で生成されるのが SFC(`⚡`付き1ファイル) ではなく class-base(2ファイル) になっている（config反映確認）
- [x] `docker build --target runtime` が単体で通る（本番ビルドの疎通）— 2026-07-10 確認済み
- [ ] `package-lock.json` が `package.json` と同期している（`npm ci` がエラーなく通る）
- [ ] `curl -v http://localhost:8080/` がリセットされず応答する（IPv6 listen 確認）