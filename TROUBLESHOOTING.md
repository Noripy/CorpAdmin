# トラブルシューティング（実際に踏んだ罠と対処）

Laravel 13 / Livewire 4 / MySQL 8.4 / Docker マルチステージ構成の環境構築で
実際に遭遇したエラー6件。**「Dockerfileが壊れている」と「Dockerfileの外側（データ・依存関係・ディレクトリ状態・OSのネットワーク挙動）が想定と違う」の見極め**がすべて。実際、6件中5件はDockerfile/compose本体は無罪だった。


## 前提の順序（Dockerfileを空ディレクトリに配置してからの流れ）

`runtime` ステージは `composer.json` などアプリ本体を `COPY` する。
つまり **Laravel をまだ scaffold していない空ディレクトリでは runtime ビルドは通らない**。
なので順序はこう:

1. Docker 関連ファイル（この一式）を空ディレクトリに置く
2. **dev コンテナで Laravel を scaffold する**（アプリ本体を生成）
3. Livewire を入れる
4. 以後、開発 or 本番ビルド

---

## 1. `COPY --from` で variable expansion エラー

```
ERROR: failed to solve: variable expansion is not supported for --from,
define a new stage with FROM using ARG from global scope as a workaround
```

- **種類**: 構文エラー
- **原因**: `COPY --from=composer:${COMPOSER_VERSION}` のように、`COPY --from` の**イメージ参照側**に変数展開は使えない。`FROM composer:${COMPOSER_VERSION} AS xxx` のような**FROM行での変数展開は問題ない**——同じ`${ARG}`でも扱いが違う。
- **対処**: 変数を使ったイメージを一度 `FROM ... AS composer_bin` のようにステージ化し、他ステージからは `COPY --from=composer_bin`（ステージ名参照）でコピーする。
- **教訓**: `FROM`と`COPY --from`は別物と覚える。

## 2. `composer.json not found` / `package-lock.json not found`

```
ERROR: ... "/package-lock.json": not found
```

- **種類**: 前提条件エラー（ビルドコンテキストにまだ実体が無い）
- **原因**: `docker build --target runtime` を、Laravel をまだ scaffold していない（Docker関連ファイルしか無い）フォルダで実行した。`vendor`/`assets`ステージは`composer.json`/`package.json`をCOPYするが、そもそも存在しない。
- **対処**: 先に「dev イメージビルド → Laravel scaffold → Livewire導入」を終わらせてから `runtime` をビルドする（SETUP.md の手順順序どおり）。
- **教訓**: `not found` は「壊れた」ではなく「無い」。まずファイルの実在を疑う。

## 3. MySQLコンテナが起動直後に `exited (1)`

```
mysqld: Table 'mysql.plugin' doesn't exist
[ERROR] Fatal error: Can't open and lock privilege tables: Table 'mysql.user' doesn't exist
```

- **種類**: 残存状態エラー（設定を直しても直らないタイプ）
- **原因（2段階）**:
  1. `command: --default-authentication-plugin=...` が原因で `mysqld` が初期化途中に異常終了（このオプションはMySQL 8.0.27で非推奨→**8.4.0で削除**。8.4はcaching_sha2_passwordが既にデフォルトなので指定自体不要）
  2. その異常終了で**中途半端なデータディレクトリ**がボリュームに残り、`command`を直した後も「システムテーブルが無い」状態のまま起動失敗を繰り返した
- **対処**: `command`行を削除。**それだけでは直らない**場合、`docker compose down -v`でボリュームごと作り直す。
- **教訓**: DBコンテナの起動失敗は「設定の問題」を直した後、必ず「残存ボリュームの問題」も疑う。切り分けは`docker compose logs db`でシステムテーブル欠損の有無を見る。

## 4. `composer create-project` が非空ディレクトリで失敗

```
Project directory "/var/www/html/." is not empty.
```

- **種類**: スキャフォールドツールの安全装置
- **原因**: Docker関連ファイルを先に置いた状態のフォルダに直接`create-project`しようとした。Composerは対象ディレクトリが空でないと拒否する仕様。
- **対処**: コンテナ内の一時ディレクトリ（`/tmp`、bind mount対象外）にscaffoldしてから、自作の`.gitignore`を退避しつつ現在地へマージする（SETUP.md 手順2参照）。
- **教訓**: 同様の「ディレクトリが空でないと拒否」は`npx create-react-app`や`rails new`など他のスキャフォールドツールでも共通の作法。

## 5. `npm ci` が lockfile 不整合で失敗

```
npm error `npm ci` can only install packages when your package.json
and package-lock.json ... are in sync.
npm error Missing: @tailwindcss/vite@4.3.2 from lock file
```

- **種類**: 依存関係の同期ズレ
- **原因**: `package.json`が更新された後に`npm install`が走らず、`package-lock.json`が古いまま取り残された。
- **対処**: `docker compose run --rm vite npm install` でlockfileを再生成し、`git diff package-lock.json`で差分を目視確認してから再ビルド。
- **教訓**: `npm ci`のエラーは「lockfile更新忘れの検知器」。`npm install`に緩めて回避するのは対症療法であり、本番の再現性を壊すので避ける。

## 6. `docker compose up` は成功するのに `http://localhost:8080` が `ERR_CONNECTION_RESET`

```
* Connected to localhost (::1) port 8080
> GET / HTTP/1.1
* Recv failure: Connection reset by peer
```
```
web-1 | 10-listen-on-ipv6-by-default.sh: info: can not modify /etc/nginx/conf.d/default.conf (read-only file system?)
```

- **種類**: OS/ネットワークスタックの差異（Dockerfile・compose本体は無罪）
- **原因（2段階）**:
  1. `docker-compose.yml` で `default.conf` を `:ro`（読み取り専用）でbind mountしているため、公式nginxイメージの起動スクリプトが本来自動で追記する`listen [::]:80;`（IPv6用）を**書き込めず失敗**していた
  2. macOS（OrbStack/Docker Desktop）は`localhost`を**IPv6(`::1`)優先で名前解決**する。ホスト⇔コンテナのポート転送自体はIPv6でも繋がるが、コンテナ内のnginxがIPv4(`listen 80;`)でしか待ち受けていないため、リクエストの渡し先が無く即座に接続がリセットされる
- **対処**: `docker/nginx/default.conf` に `listen [::]:80;` を明示的に追加する（自動パッチに頼らず自前で書く）。`docker compose restart web` で反映（イメージ再ビルド不要）。
- **教訓**:
  - 設定ファイルを`:ro`でマウントする判断は良いが、そのイメージの**entrypointが起動時に設定を書き換える前提で作られていないか**は事前確認が要る。
  - **macOSはlocalhostがIPv6優先で解決される**——同じcomposeでもLinux CI環境では再現しない可能性がある。「動く/動かない」の環境差が出たら、まずOS・ネットワークスタックの違いを疑う。
  - nginxのアクセス/エラーログに**何も記録されない**（起動ログしかない）場合は、「nginxまでリクエストが届いていない」ことを示す有力な手がかりになる。

---

## エラーの見分け方（切り分けの型）

| 症状 | まず疑うもの |
|---|---|
| `docker build` が構文エラーで落ちる | Dockerfileの記法そのもの（変数展開の可否など） |
| `not found` 系のCOPYエラー | ビルドコンテキストに実体がまだ無いだけでは？ |
| コンテナが起動直後に `exited` | ①起動オプション/設定 → ②直しても同じなら残存ボリューム |
| CLIツールが「ディレクトリが空でない」で拒否 | ツール側の安全装置。空の一時ディレクトリ経由でマージ |
| `npm ci` / `composer install --no-dev` 系が失敗 | lockfileと定義ファイルの同期ズレ |
| ポートは繋がるがレスポンスが返らない/リセットされる | OS・ネットワークスタックの差異（IPv4/IPv6等）、ログに何も残っていないか確認 |
