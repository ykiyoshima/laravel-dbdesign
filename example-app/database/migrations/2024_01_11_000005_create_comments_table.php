<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * コメントテーブル - 記事へのコメント
     * 学習ポイント:
     * - 自己参照（親コメント）
     * - NULLable外部キー
     * - ツリー構造の実装
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            
            // 外部キー: 記事
            $table->foreignId('post_id')
                  ->constrained('posts')
                  ->onDelete('cascade');
            
            // 外部キー: ユーザー（NULL許可 - ゲストコメント対応）
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            
            // 自己参照: 親コメント（返信機能のため）
            // 親コメントが削除されたら子コメントも削除
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('comments')
                  ->onDelete('cascade');
            
            // ゲストユーザー情報（user_idがNULLの場合）
            $table->string('guest_name', 100)->nullable();
            $table->string('guest_email', 100)->nullable();
            
            // コメント本文
            $table->text('content');
            
            // 承認ステータス
            $table->boolean('is_approved')->default(false);
            
            $table->timestamps();
            
            // インデックス: 記事のコメント一覧表示を高速化
            $table->index('post_id');
            
            // インデックス: 承認されたコメントの絞り込みを高速化
            $table->index('is_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
