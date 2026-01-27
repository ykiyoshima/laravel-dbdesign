<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * 技術ブログのサンプルデータを投入
     */
    public function run(): void
    {
        // 1. ユーザーを作成
        $users = [
            User::factory()->create([
                'name' => '山田太郎',
                'email' => 'yamada@example.com',
            ]),
            User::factory()->create([
                'name' => '佐藤花子',
                'email' => 'sato@example.com',
            ]),
            User::factory()->create([
                'name' => '田中一郎',
                'email' => 'tanaka@example.com',
            ]),
        ];

        // 2. カテゴリを作成（1対多の「1」側）
        $categories = [
            Category::create([
                'name' => 'プログラミング',
                'slug' => 'programming',
                'description' => 'プログラミング言語や開発手法に関する記事',
            ]),
            Category::create([
                'name' => 'フロントエンド',
                'slug' => 'frontend',
                'description' => 'HTML、CSS、JavaScriptなどフロントエンド技術に関する記事',
            ]),
            Category::create([
                'name' => 'バックエンド',
                'slug' => 'backend',
                'description' => 'サーバーサイド開発に関する記事',
            ]),
            Category::create([
                'name' => 'デザイン',
                'slug' => 'design',
                'description' => 'UIデザインやUXに関する記事',
            ]),
        ];

        // 3. タグを作成（多対多リレーションの片側）
        $tags = [
            Tag::create(['name' => 'PHP', 'slug' => 'php']),
            Tag::create(['name' => 'Laravel', 'slug' => 'laravel']),
            Tag::create(['name' => 'JavaScript', 'slug' => 'javascript']),
            Tag::create(['name' => 'React', 'slug' => 'react']),
            Tag::create(['name' => '初心者向け', 'slug' => 'beginner']),
            Tag::create(['name' => '中級者向け', 'slug' => 'intermediate']),
            Tag::create(['name' => '上級者向け', 'slug' => 'advanced']),
            Tag::create(['name' => 'チュートリアル', 'slug' => 'tutorial']),
            Tag::create(['name' => 'ベストプラクティス', 'slug' => 'best-practices']),
            Tag::create(['name' => 'パフォーマンス', 'slug' => 'performance']),
        ];

        // 4. 記事を作成（著者ごとに記事数を変えて1対多の関係を明確化）
        $posts = [
            // 山田太郎の記事（8件）- 最も活発な著者
            Post::create([
                'title' => '2024年のWebデザイントレンド',
                'slug' => 'web-design-trends-2024',
                'excerpt' => '今年注目のWebデザイントレンドをまとめました。',
                'content' => "2024年のWebデザインは、ミニマリズムと大胆な色使いの融合が特徴です。\n\nグラスモーフィズムやニューモーフィズムといった視覚効果も引き続き人気です。また、アクセシビリティを重視したデザインがますます重要になっています。",
                'user_id' => $users[0]->id,
                'category_id' => $categories[3]->id,
                'status' => 'published',
                'published_at' => now()->subDays(25),
                'view_count' => 420,
            ]),
            Post::create([
                'title' => 'Tailwind CSSで素早くスタイリング',
                'slug' => 'tailwind-css-quick-styling',
                'excerpt' => 'Tailwind CSSを使った効率的なスタイリング方法',
                'content' => "Tailwind CSSは、ユーティリティファーストのCSSフレームワークです。\n\nクラス名を組み合わせるだけで、素早くスタイリングできます。カスタマイズも簡単で、独自のデザインシステムを構築できます。",
                'user_id' => $users[0]->id,
                'category_id' => $categories[1]->id,
                'status' => 'published',
                'published_at' => now()->subDays(20),
                'view_count' => 350,
            ]),
            Post::create([
                'title' => 'VS Codeの便利な拡張機能10選',
                'slug' => 'vscode-extensions-top-10',
                'excerpt' => '開発効率を上げるVS Code拡張機能を紹介',
                'content' => "Visual Studio Codeは、豊富な拡張機能が魅力です。\n\nPrettier、ESLint、GitLensなど、開発を快適にする拡張機能を厳選しました。これらを使えば、コーディングがさらに楽しくなります。",
                'user_id' => $users[0]->id,
                'category_id' => $categories[0]->id,
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'view_count' => 280,
            ]),
            Post::create([
                'title' => 'JavaScriptの非同期処理を理解する',
                'slug' => 'javascript-async-programming',
                'excerpt' => 'async/awaitとPromiseの使い方を解説',
                'content' => "非同期処理は、JavaScriptの重要な概念です。\n\nコールバック地獄から抜け出し、async/awaitを使った読みやすいコードを書く方法を学びましょう。エラーハンドリングのベストプラクティスも紹介します。",
                'user_id' => $users[0]->id,
                'category_id' => $categories[0]->id,
                'status' => 'published',
                'published_at' => now()->subDays(12),
                'view_count' => 195,
            ]),
            Post::create([
                'title' => 'Gitのブランチ戦略とチーム開発',
                'slug' => 'git-branching-strategy',
                'excerpt' => 'Git FlowとGitHub Flowの違いと使い分け',
                'content' => "チーム開発では、適切なブランチ戦略が重要です。\n\nGit FlowとGitHub Flowの特徴を理解し、プロジェクトに最適な戦略を選びましょう。プルリクエストのレビュー文化についても解説します。",
                'user_id' => $users[0]->id,
                'category_id' => $categories[0]->id,
                'status' => 'published',
                'published_at' => now()->subDays(8),
                'view_count' => 167,
            ]),
            Post::create([
                'title' => 'レスポンシブデザインの基本',
                'slug' => 'responsive-design-basics',
                'excerpt' => 'モバイルファーストで作るレスポンシブWebサイト',
                'content' => "モバイルデバイスの利用が増える中、レスポンシブデザインは必須です。\n\nメディアクエリ、フレキシブルグリッド、フルードイメージを活用して、あらゆる画面サイズに対応したサイトを作りましょう。",
                'user_id' => $users[0]->id,
                'category_id' => $categories[1]->id,
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'view_count' => 310,
            ]),
            Post::create([
                'title' => 'Docker入門：コンテナで開発環境を統一',
                'slug' => 'docker-getting-started',
                'excerpt' => 'Dockerを使った開発環境構築の基本',
                'content' => "Dockerを使えば、「自分の環境では動くのに...」という問題から解放されます。\n\nコンテナの基本概念から、docker-composeを使った複数コンテナの管理まで、実践的に学びます。",
                'user_id' => $users[0]->id,
                'category_id' => $categories[2]->id,
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'view_count' => 143,
            ]),
            Post::create([
                'title' => 'パフォーマンスチューニングの基礎',
                'slug' => 'web-performance-tuning',
                'excerpt' => 'Webサイトの表示速度を改善する方法',
                'content' => "ページの読み込み速度は、ユーザー体験に大きく影響します。\n\n画像の最適化、コードの圧縮、キャッシュの活用など、パフォーマンス改善のテクニックを紹介します。",
                'user_id' => $users[0]->id,
                'category_id' => $categories[1]->id,
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'view_count' => 89,
            ]),

            // 佐藤花子の記事（5件）
            Post::create([
                'title' => 'フロントエンド開発の始め方',
                'slug' => 'frontend-development-guide',
                'excerpt' => '初心者向けフロントエンド学習ロードマップ',
                'content' => "フロントエンド開発を始めたい方へ、学習の道筋を示します。\n\nHTML、CSS、JavaScriptの基礎から、フレームワークの選び方まで、段階的に学ぶ方法を解説します。",
                'user_id' => $users[1]->id,
                'category_id' => $categories[1]->id,
                'status' => 'published',
                'published_at' => now()->subDays(18),
                'view_count' => 520,
            ]),
            Post::create([
                'title' => 'カラーパレットの選び方',
                'slug' => 'choosing-color-palette',
                'excerpt' => '魅力的な配色を作るコツ',
                'content' => "色選びは、デザインの印象を大きく左右します。\n\n色彩理論の基礎から、ツールを使った配色の作り方まで、実践的なテクニックを紹介します。",
                'user_id' => $users[1]->id,
                'category_id' => $categories[3]->id,
                'status' => 'published',
                'published_at' => now()->subDays(14),
                'view_count' => 267,
            ]),
            Post::create([
                'title' => 'CSSアニメーションで動きをつける',
                'slug' => 'css-animations-guide',
                'excerpt' => 'transitionとanimationを使いこなす',
                'content' => "CSSアニメーションを使えば、JavaScriptなしで動きのあるUIを作れます。\n\ntransitionとanimationの違いを理解し、滑らかなアニメーションを実装しましょう。パフォーマンスの注意点も解説します。",
                'user_id' => $users[1]->id,
                'category_id' => $categories[1]->id,
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'view_count' => 198,
            ]),
            Post::create([
                'title' => 'タイポグラフィの基本',
                'slug' => 'typography-basics',
                'excerpt' => '読みやすい文字組みのポイント',
                'content' => "優れたタイポグラフィは、読みやすさと美しさを両立します。\n\nフォント選び、行間、字間など、Webタイポグラフィの基本を学びます。",
                'user_id' => $users[1]->id,
                'category_id' => $categories[3]->id,
                'status' => 'published',
                'published_at' => now()->subDays(6),
                'view_count' => 156,
            ]),
            Post::create([
                'title' => 'アクセシビリティを考慮したデザイン',
                'slug' => 'accessible-web-design',
                'excerpt' => '誰もが使いやすいWebサイトを作る',
                'content' => "アクセシビリティは、すべてのユーザーにとって重要です。\n\nWCAGガイドラインに沿った、色のコントラスト、キーボード操作、スクリーンリーダー対応など、実践的な改善方法を紹介します。",
                'user_id' => $users[1]->id,
                'category_id' => $categories[3]->id,
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'view_count' => 134,
            ]),

            // 田中一郎の記事（2件）- 新しく参加した著者
            Post::create([
                'title' => 'PHPの新機能を試してみた',
                'slug' => 'php-new-features',
                'excerpt' => '最新PHPバージョンの新機能レビュー',
                'content' => "PHPは日々進化しています。\n\n最新バージョンで追加された便利な機能を実際に使ってみた感想をまとめました。Enumやread-only プロパティなど、実務で役立つ機能を紹介します。",
                'user_id' => $users[2]->id,
                'category_id' => $categories[2]->id,
                'status' => 'published',
                'published_at' => now()->subDays(4),
                'view_count' => 112,
            ]),
            Post::create([
                'title' => 'エンジニアのキャリアパスを考える',
                'slug' => 'engineer-career-path',
                'excerpt' => '技術を極めるか、マネジメントに進むか',
                'content' => "エンジニアのキャリアには様々な選択肢があります。\n\nスペシャリストとして技術を深めるか、マネジメントに進むか。自分に合ったキャリアパスを見つけるヒントをお伝えします。",
                'user_id' => $users[2]->id,
                'category_id' => $categories[0]->id,
                'status' => 'published',
                'published_at' => now()->subHours(18),
                'view_count' => 67,
            ]),
        ];

        // 5. タグを記事に紐付け（多対多リレーション - 使用頻度に偏りを作る）
        // 各記事に対して一度だけタグを設定
        
        // 記事0: 2024年のWebデザイントレンド
        $posts[0]->tags()->attach([$tags[4]->id, $tags[8]->id]); // 初心者向け, ベストプラクティス
        
        // 記事1: Tailwind CSS
        $posts[1]->tags()->attach([$tags[7]->id, $tags[8]->id]); // チュートリアル, ベストプラクティス
        
        // 記事2: VS Code拡張機能
        $posts[2]->tags()->attach([$tags[4]->id]); // 初心者向け
        
        // 記事3: JavaScript非同期処理
        $posts[3]->tags()->attach([$tags[2]->id, $tags[7]->id]); // JavaScript, チュートリアル
        
        // 記事4: Gitブランチ戦略
        $posts[4]->tags()->attach([$tags[5]->id, $tags[8]->id]); // 中級者向け, ベストプラクティス
        
        // 記事5: レスポンシブデザイン
        $posts[5]->tags()->attach([$tags[4]->id]); // 初心者向け
        
        // 記事6: Docker入門
        $posts[6]->tags()->attach([$tags[1]->id, $tags[5]->id, $tags[7]->id]); // Laravel, 中級者向け, チュートリアル
        
        // 記事7: パフォーマンスチューニング
        $posts[7]->tags()->attach([$tags[8]->id, $tags[9]->id]); // ベストプラクティス, パフォーマンス
        
        // 記事8: フロントエンド開発の始め方
        $posts[8]->tags()->attach([$tags[4]->id, $tags[2]->id, $tags[7]->id]); // 初心者向け, JavaScript, チュートリアル
        
        // 記事9: カラーパレットの選び方
        $posts[9]->tags()->attach([$tags[8]->id]); // ベストプラクティス
        
        // 記事10: CSSアニメーション
        $posts[10]->tags()->attach([$tags[4]->id, $tags[2]->id, $tags[3]->id]); // 初心者向け, JavaScript, React
        
        // 記事11: タイポグラフィの基本
        $posts[11]->tags()->attach([$tags[7]->id]); // チュートリアル
        
        // 記事12: アクセシビリティを考慮したデザイン
        $posts[12]->tags()->attach([$tags[4]->id, $tags[8]->id]); // 初心者向け, ベストプラクティス
        
        // 記事13: PHPの新機能
        $posts[13]->tags()->attach([$tags[0]->id, $tags[5]->id]); // PHP, 中級者向け
        
        // 記事14: エンジニアのキャリアパス
        $posts[14]->tags()->attach([$tags[4]->id]); // 初心者向け
        
        // タグ使用頻度の結果:
        // 初心者向け: 7記事 (0,2,5,8,10,12,14)
        // チュートリアル: 5記事 (1,3,6,8,11)
        // ベストプラクティス: 6記事 (0,1,4,7,9,12)
        // JavaScript: 3記事 (3,8,10)
        // 中級者向け: 3記事 (4,6,13)
        // パフォーマンス: 1記事 (7)
        // PHP: 1記事 (13)
        // Laravel: 1記事 (6)
        // React: 1記事 (10)
        // 上級者向け: 0記事 (未使用)

        // 6. コメントを作成（1対多 + 自己参照 - より複雑な返信構造）
        
        // 記事1へのコメント（人気記事なので多くのコメント）
        $comment1_1 = Comment::create([
            'post_id' => $posts[0]->id,
            'user_id' => $users[1]->id,
            'content' => 'グラスモーフィズムのトレンドは今年も続きそうですね！',
            'is_approved' => true,
        ]);

        $reply1_1_1 = Comment::create([
            'post_id' => $posts[0]->id,
            'user_id' => $users[0]->id,
            'parent_id' => $comment1_1->id,
            'content' => 'はい、特にダッシュボードUIで人気が高まっています。',
            'is_approved' => true,
        ]);

        // 返信に対するさらなる返信（3階層目）
        Comment::create([
            'post_id' => $posts[0]->id,
            'user_id' => $users[2]->id,
            'parent_id' => $reply1_1_1->id,
            'content' => 'ダッシュボードの実装例があれば見てみたいです。',
            'is_approved' => true,
        ]);

        $comment1_2 = Comment::create([
            'post_id' => $posts[0]->id,
            'user_id' => null,
            'guest_name' => '鈴木',
            'guest_email' => 'suzuki@example.com',
            'content' => 'アクセシビリティ重視のデザインについてもっと知りたいです。',
            'is_approved' => true,
        ]);

        Comment::create([
            'post_id' => $posts[0]->id,
            'user_id' => $users[0]->id,
            'parent_id' => $comment1_2->id,
            'content' => '次回の記事でアクセシビリティについて詳しく書く予定です！',
            'is_approved' => true,
        ]);

        // 記事2へのコメント
        $comment2_1 = Comment::create([
            'post_id' => $posts[1]->id,
            'user_id' => $users[1]->id,
            'content' => 'Tailwindは本当に便利ですよね。カスタマイズの方法も知りたいです。',
            'is_approved' => true,
        ]);

        Comment::create([
            'post_id' => $posts[1]->id,
            'user_id' => $users[0]->id,
            'parent_id' => $comment2_1->id,
            'content' => 'tailwind.config.jsの設定方法について別記事で解説します！',
            'is_approved' => true,
        ]);

        // 記事3へのコメント
        Comment::create([
            'post_id' => $posts[2]->id,
            'user_id' => $users[2]->id,
            'content' => 'Prettier と ESLint は必須ですね。',
            'is_approved' => true,
        ]);

        // 記事4へのコメント（活発な議論）
        $comment4_1 = Comment::create([
            'post_id' => $posts[3]->id,
            'user_id' => $users[1]->id,
            'content' => 'async/awaitの使い方がよくわかりました！',
            'is_approved' => true,
        ]);

        $comment4_2 = Comment::create([
            'post_id' => $posts[3]->id,
            'user_id' => null,
            'guest_name' => '山本',
            'guest_email' => 'yamamoto@example.com',
            'content' => 'try-catchのエラーハンドリングで注意すべき点はありますか？',
            'is_approved' => true,
        ]);

        $reply4_2_1 = Comment::create([
            'post_id' => $posts[3]->id,
            'user_id' => $users[0]->id,
            'parent_id' => $comment4_2->id,
            'content' => 'async関数内では必ずtry-catchを使うか、.catchメソッドでエラーを捕捉しましょう。',
            'is_approved' => true,
        ]);

        Comment::create([
            'post_id' => $posts[3]->id,
            'user_id' => $users[2]->id,
            'parent_id' => $reply4_2_1->id,
            'content' => 'エラーハンドリングのベストプラクティス記事も読みたいです！',
            'is_approved' => true,
        ]);

        // 記事8へのコメント
        Comment::create([
            'post_id' => $posts[7]->id,
            'user_id' => $users[1]->id,
            'content' => 'パフォーマンス改善は奥が深いですね。',
            'is_approved' => true,
        ]);

        // 記事9へのコメント
        $comment9_1 = Comment::create([
            'post_id' => $posts[8]->id,
            'user_id' => $users[2]->id,
            'content' => 'まさに私が探していた記事です！ありがとうございます。',
            'is_approved' => true,
        ]);

        Comment::create([
            'post_id' => $posts[8]->id,
            'user_id' => $users[1]->id,
            'parent_id' => $comment9_1->id,
            'content' => 'お役に立てて嬉しいです。一緒に頑張りましょう！',
            'is_approved' => true,
        ]);

        // 記事11へのコメント
        Comment::create([
            'post_id' => $posts[10]->id,
            'user_id' => $users[0]->id,
            'content' => 'CSSアニメーションは軽量で良いですよね。',
            'is_approved' => true,
        ]);

        // 記事15へのコメント
        Comment::create([
            'post_id' => $posts[14]->id,
            'user_id' => $users[1]->id,
            'content' => 'キャリアについて考えるきっかけになりました。',
            'is_approved' => true,
        ]);
    }
}
