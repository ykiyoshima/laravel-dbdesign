# セットアップ手順

1. ルートディレクトリで次のコマンドを実行する
    ```bash
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
    ```
    - `docker: Error: remote trust data does not exist for ...`のようなエラーが表示された場合は、次のコマンドを実行してから再度試してみてください。
        ```bash
        export DOCKER_CONTENT_TRUST=0
        ```
2. .envを作成する次のコマンドを実行する
    ```bash
    cp .env.example .env
    ```
    - 上記コマンドが失敗する場合は、Visual Studio Codeの画面から直接.env.exampleを複製して、ファイル名を`.env`に変更してください。
3. サンプルアプリケーションの実行環境を起動する次のコマンドを実行する
    ```bash
    vendor/bin/sail up -d
    ```
4. Laravelの`APP_KEY`を生成する次のコマンドを実行する
    ```bash
    vendor/bin/sail artisan key:generate
    ```
5. データベースを作成する次のコマンドを実行する
    ```bash
    vendor/bin/sail artisan migrate --seed
    ```
6. `http://localhost`にアクセスし、記事投稿のサンプルアプリケーションの画面が表示されることを確認する
    - `http://localhost:8080`にアクセスすると、サンプルアプリケーションで使用しているデータベースが参照できるphpmyadminを開くことができます。