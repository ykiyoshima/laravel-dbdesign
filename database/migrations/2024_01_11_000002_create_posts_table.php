<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * 記事テーブル - ブログの中心となるテーブル
     * 学習ポイント:
     * - 外部キー制約（user_id, category_id）
     * - カスケード削除
     * - 複合インデックス
     * - ENUM型の利用
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200); // 記事タイトル
            $table->string('slug', 200)->unique(); // URL用スラッグ
            $table->text('excerpt')->nullable(); // 記事の抜粋
            $table->longText('content'); // 記事本文
            
            // 外部キー: ユーザー（1対多のリレーション）
            // ユーザーが削除されたら記事も削除（CASCADE）
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // 外部キー: カテゴリ（1対多のリレーション）
            // カテゴリが削除された場合はNULLに設定
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('set null');
            
            // ステータス（ENUM型の代わりにstringを使用）
            $table->string('status', 20)->default('draft'); // draft, published, archived
            
            // 公開日時
            $table->timestamp('published_at')->nullable();
            
            // 閲覧数（統計情報）
            $table->unsignedInteger('view_count')->default(0);
            
            $table->timestamps();
            
            // 複合インデックス: ステータスと公開日時での検索を高速化
            $table->index(['status', 'published_at']);
            
            // インデックス: ユーザーの記事一覧表示を高速化
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
