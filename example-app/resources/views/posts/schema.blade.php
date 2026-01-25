@extends('layouts.app')

@section('title', 'データベーススキーマ - DB設計学習')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">📊 データベーススキーマ</h1>
    <p class="text-gray-600 mb-8">このアプリケーションで使用しているデータベース構造を学習します</p>

    <!-- テーブル一覧 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
        <!-- Usersテーブル -->
        <div class="border-2 border-blue-300 rounded-lg p-6 bg-blue-50">
            <h2 class="text-2xl font-bold text-blue-800 mb-4 flex items-center">
                👤 users
                <span class="ml-3 text-xs bg-blue-200 px-2 py-1 rounded">基本テーブル</span>
            </h2>
            <table class="w-full text-sm">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="text-left p-2">カラム名</th>
                        <th class="text-left p-2">型</th>
                        <th class="text-left p-2">説明</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr><td class="p-2 font-mono">id</td><td class="p-2">BIGINT</td><td class="p-2">🔑 主キー</td></tr>
                    <tr><td class="p-2 font-mono">name</td><td class="p-2">VARCHAR</td><td class="p-2">ユーザー名</td></tr>
                    <tr><td class="p-2 font-mono">email</td><td class="p-2">VARCHAR</td><td class="p-2">メール (UNIQUE)</td></tr>
                    <tr><td class="p-2 font-mono">password</td><td class="p-2">VARCHAR</td><td class="p-2">パスワード</td></tr>
                    <tr><td class="p-2 font-mono">created_at</td><td class="p-2">TIMESTAMP</td><td class="p-2">作成日時</td></tr>
                    <tr><td class="p-2 font-mono">updated_at</td><td class="p-2">TIMESTAMP</td><td class="p-2">更新日時</td></tr>
                </tbody>
            </table>
            <div class="mt-4 text-xs text-gray-700">
                <p><strong>リレーション:</strong></p>
                <ul class="list-disc list-inside">
                    <li>hasMany → posts (1対多)</li>
                    <li>hasMany → comments (1対多)</li>
                </ul>
            </div>
        </div>

        <!-- Categoriesテーブル -->
        <div class="border-2 border-green-300 rounded-lg p-6 bg-green-50">
            <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center">
                📁 categories
                <span class="ml-3 text-xs bg-green-200 px-2 py-1 rounded">マスタ</span>
            </h2>
            <table class="w-full text-sm">
                <thead class="bg-green-100">
                    <tr>
                        <th class="text-left p-2">カラム名</th>
                        <th class="text-left p-2">型</th>
                        <th class="text-left p-2">説明</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr><td class="p-2 font-mono">id</td><td class="p-2">BIGINT</td><td class="p-2">🔑 主キー</td></tr>
                    <tr><td class="p-2 font-mono">name</td><td class="p-2">VARCHAR</td><td class="p-2">カテゴリ名</td></tr>
                    <tr><td class="p-2 font-mono">slug</td><td class="p-2">VARCHAR</td><td class="p-2">スラッグ (UNIQUE)</td></tr>
                    <tr><td class="p-2 font-mono">description</td><td class="p-2">TEXT</td><td class="p-2">説明</td></tr>
                    <tr><td class="p-2 font-mono">created_at</td><td class="p-2">TIMESTAMP</td><td class="p-2">作成日時</td></tr>
                    <tr><td class="p-2 font-mono">updated_at</td><td class="p-2">TIMESTAMP</td><td class="p-2">更新日時</td></tr>
                </tbody>
            </table>
            <div class="mt-4 text-xs text-gray-700">
                <p><strong>リレーション:</strong></p>
                <ul class="list-disc list-inside">
                    <li>hasMany → posts (1対多)</li>
                </ul>
                <p class="mt-2"><strong>インデックス:</strong> name</p>
            </div>
        </div>

        <!-- Postsテーブル -->
        <div class="border-2 border-purple-300 rounded-lg p-6 bg-purple-50">
            <h2 class="text-2xl font-bold text-purple-800 mb-4 flex items-center">
                📝 posts
                <span class="ml-3 text-xs bg-purple-200 px-2 py-1 rounded">中心テーブル</span>
            </h2>
            <table class="w-full text-sm">
                <thead class="bg-purple-100">
                    <tr>
                        <th class="text-left p-2">カラム名</th>
                        <th class="text-left p-2">型</th>
                        <th class="text-left p-2">説明</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr><td class="p-2 font-mono">id</td><td class="p-2">BIGINT</td><td class="p-2">🔑 主キー</td></tr>
                    <tr><td class="p-2 font-mono">title</td><td class="p-2">VARCHAR</td><td class="p-2">タイトル</td></tr>
                    <tr><td class="p-2 font-mono">slug</td><td class="p-2">VARCHAR</td><td class="p-2">スラッグ (UNIQUE)</td></tr>
                    <tr><td class="p-2 font-mono">content</td><td class="p-2">LONGTEXT</td><td class="p-2">本文</td></tr>
                    <tr class="bg-yellow-50">
                        <td class="p-2 font-mono font-bold">user_id</td>
                        <td class="p-2">BIGINT</td>
                        <td class="p-2">🔗 FK → users</td>
                    </tr>
                    <tr class="bg-yellow-50">
                        <td class="p-2 font-mono font-bold">category_id</td>
                        <td class="p-2">BIGINT</td>
                        <td class="p-2">🔗 FK → categories</td>
                    </tr>
                    <tr><td class="p-2 font-mono">status</td><td class="p-2">VARCHAR</td><td class="p-2">ステータス</td></tr>
                    <tr><td class="p-2 font-mono">published_at</td><td class="p-2">TIMESTAMP</td><td class="p-2">公開日時</td></tr>
                    <tr><td class="p-2 font-mono">view_count</td><td class="p-2">INT</td><td class="p-2">閲覧数</td></tr>
                </tbody>
            </table>
            <div class="mt-4 text-xs text-gray-700">
                <p><strong>外部キー制約:</strong></p>
                <ul class="list-disc list-inside">
                    <li>user_id → users.id (CASCADE削除)</li>
                    <li>category_id → categories.id (NULL設定)</li>
                </ul>
                <p class="mt-2"><strong>複合インデックス:</strong> (status, published_at)</p>
            </div>
        </div>

        <!-- Tagsテーブル -->
        <div class="border-2 border-orange-300 rounded-lg p-6 bg-orange-50">
            <h2 class="text-2xl font-bold text-orange-800 mb-4 flex items-center">
                🏷️ tags
                <span class="ml-3 text-xs bg-orange-200 px-2 py-1 rounded">マスタ</span>
            </h2>
            <table class="w-full text-sm">
                <thead class="bg-orange-100">
                    <tr>
                        <th class="text-left p-2">カラム名</th>
                        <th class="text-left p-2">型</th>
                        <th class="text-left p-2">説明</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr><td class="p-2 font-mono">id</td><td class="p-2">BIGINT</td><td class="p-2">🔑 主キー</td></tr>
                    <tr><td class="p-2 font-mono">name</td><td class="p-2">VARCHAR</td><td class="p-2">タグ名 (UNIQUE)</td></tr>
                    <tr><td class="p-2 font-mono">slug</td><td class="p-2">VARCHAR</td><td class="p-2">スラッグ (UNIQUE)</td></tr>
                    <tr><td class="p-2 font-mono">created_at</td><td class="p-2">TIMESTAMP</td><td class="p-2">作成日時</td></tr>
                    <tr><td class="p-2 font-mono">updated_at</td><td class="p-2">TIMESTAMP</td><td class="p-2">更新日時</td></tr>
                </tbody>
            </table>
            <div class="mt-4 text-xs text-gray-700">
                <p><strong>リレーション:</strong></p>
                <ul class="list-disc list-inside">
                    <li>belongsToMany → posts (多対多)</li>
                </ul>
                <p class="mt-2"><strong>インデックス:</strong> name</p>
            </div>
        </div>

        <!-- Post_Tagテーブル (中間テーブル) -->
        <div class="border-2 border-pink-300 rounded-lg p-6 bg-pink-50">
            <h2 class="text-2xl font-bold text-pink-800 mb-4 flex items-center">
                🔗 post_tag
                <span class="ml-3 text-xs bg-pink-200 px-2 py-1 rounded">中間テーブル</span>
            </h2>
            <table class="w-full text-sm">
                <thead class="bg-pink-100">
                    <tr>
                        <th class="text-left p-2">カラム名</th>
                        <th class="text-left p-2">型</th>
                        <th class="text-left p-2">説明</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr class="bg-yellow-50">
                        <td class="p-2 font-mono font-bold">post_id</td>
                        <td class="p-2">BIGINT</td>
                        <td class="p-2">🔗 FK → posts</td>
                    </tr>
                    <tr class="bg-yellow-50">
                        <td class="p-2 font-mono font-bold">tag_id</td>
                        <td class="p-2">BIGINT</td>
                        <td class="p-2">🔗 FK → tags</td>
                    </tr>
                    <tr><td class="p-2 font-mono">created_at</td><td class="p-2">TIMESTAMP</td><td class="p-2">作成日時</td></tr>
                    <tr><td class="p-2 font-mono">updated_at</td><td class="p-2">TIMESTAMP</td><td class="p-2">更新日時</td></tr>
                </tbody>
            </table>
            <div class="mt-4 text-xs text-gray-700">
                <p><strong>複合主キー:</strong> (post_id, tag_id)</p>
                <p class="mt-2"><strong>外部キー制約:</strong></p>
                <ul class="list-disc list-inside">
                    <li>post_id → posts.id (CASCADE削除)</li>
                    <li>tag_id → tags.id (CASCADE削除)</li>
                </ul>
                <p class="mt-2 font-semibold text-pink-700">
                    ⭐ 多対多リレーションを実現するピボットテーブル
                </p>
            </div>
        </div>

        <!-- Commentsテーブル -->
        <div class="border-2 border-teal-300 rounded-lg p-6 bg-teal-50">
            <h2 class="text-2xl font-bold text-teal-800 mb-4 flex items-center">
                💬 comments
                <span class="ml-3 text-xs bg-teal-200 px-2 py-1 rounded">自己参照</span>
            </h2>
            <table class="w-full text-sm">
                <thead class="bg-teal-100">
                    <tr>
                        <th class="text-left p-2">カラム名</th>
                        <th class="text-left p-2">型</th>
                        <th class="text-left p-2">説明</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr><td class="p-2 font-mono">id</td><td class="p-2">BIGINT</td><td class="p-2">🔑 主キー</td></tr>
                    <tr class="bg-yellow-50">
                        <td class="p-2 font-mono font-bold">post_id</td>
                        <td class="p-2">BIGINT</td>
                        <td class="p-2">🔗 FK → posts</td>
                    </tr>
                    <tr class="bg-yellow-50">
                        <td class="p-2 font-mono font-bold">user_id</td>
                        <td class="p-2">BIGINT</td>
                        <td class="p-2">🔗 FK → users (NULL可)</td>
                    </tr>
                    <tr class="bg-red-50">
                        <td class="p-2 font-mono font-bold">parent_id</td>
                        <td class="p-2">BIGINT</td>
                        <td class="p-2">🔄 FK → comments (自己参照)</td>
                    </tr>
                    <tr><td class="p-2 font-mono">content</td><td class="p-2">TEXT</td><td class="p-2">コメント本文</td></tr>
                    <tr><td class="p-2 font-mono">is_approved</td><td class="p-2">BOOLEAN</td><td class="p-2">承認フラグ</td></tr>
                    <tr><td class="p-2 font-mono">guest_name</td><td class="p-2">VARCHAR</td><td class="p-2">ゲスト名</td></tr>
                    <tr><td class="p-2 font-mono">guest_email</td><td class="p-2">VARCHAR</td><td class="p-2">ゲストメール</td></tr>
                </tbody>
            </table>
            <div class="mt-4 text-xs text-gray-700">
                <p><strong>外部キー制約:</strong></p>
                <ul class="list-disc list-inside">
                    <li>post_id → posts.id (CASCADE削除)</li>
                    <li>user_id → users.id (NULL設定)</li>
                    <li>parent_id → comments.id (CASCADE削除)</li>
                </ul>
                <p class="mt-2 font-semibold text-teal-700">
                    ⭐ 自己参照により返信機能を実現
                </p>
            </div>
        </div>
    </div>

    <!-- ER図的な関係図 -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-8 text-white">
        <h2 class="text-3xl font-bold mb-6">🔗 テーブル間のリレーション</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white bg-opacity-10 rounded-lg p-4">
                <h3 class="font-bold text-lg mb-2">1対多 (One to Many)</h3>
                <ul class="text-sm space-y-1">
                    <li>users → posts</li>
                    <li>users → comments</li>
                    <li>categories → posts</li>
                    <li>posts → comments</li>
                    <li>comments → comments (返信)</li>
                </ul>
            </div>

            <div class="bg-white bg-opacity-10 rounded-lg p-4">
                <h3 class="font-bold text-lg mb-2">多対多 (Many to Many)</h3>
                <ul class="text-sm space-y-1">
                    <li>posts ↔ tags</li>
                    <li class="text-xs opacity-75">中間テーブル: post_tag</li>
                </ul>
            </div>

            <div class="bg-white bg-opacity-10 rounded-lg p-4">
                <h3 class="font-bold text-lg mb-2">自己参照 (Self Reference)</h3>
                <ul class="text-sm space-y-1">
                    <li>comments → comments</li>
                    <li class="text-xs opacity-75">parent_id による親子関係</li>
                </ul>
            </div>
        </div>

        <div class="mt-6 bg-white bg-opacity-10 rounded-lg p-4">
            <h3 class="font-bold text-lg mb-3">📚 学習できる概念</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>✅ 外部キー制約</div>
                <div>✅ CASCADE削除</div>
                <div>✅ SET NULL</div>
                <div>✅ 正規化</div>
                <div>✅ 複合主キー</div>
                <div>✅ ユニーク制約</div>
                <div>✅ インデックス</div>
                <div>✅ Eager Loading</div>
            </div>
        </div>
    </div>

    <!-- マイグレーションファイル一覧 -->
    <div class="mt-12 bg-gray-50 rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">📄 マイグレーションファイル</h2>
        <div class="space-y-2 text-sm font-mono">
            <p>📝 2024_01_11_000001_create_categories_table.php</p>
            <p>📝 2024_01_11_000002_create_posts_table.php</p>
            <p>📝 2024_01_11_000003_create_tags_table.php</p>
            <p>📝 2024_01_11_000004_create_post_tag_table.php</p>
            <p>📝 2024_01_11_000005_create_comments_table.php</p>
        </div>
    </div>
</div>
@endsection
