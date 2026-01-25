<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * 検索・ソート機能の高速化のためのインデックスを追加
     * - title: キーワード検索用
     * - view_count: 閲覧数順ソート用
     * - フルテキストインデックス: title + content の全文検索用（MySQL 5.7+）
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // タイトル検索用インデックス
            $table->index('title');
            
            // 閲覧数ソート用インデックス
            $table->index('view_count');
            
            // フルテキストインデックス（MySQL/PostgreSQL対応）
            $table->fullText(['title', 'content']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // インデックスを削除
            $table->dropIndex(['title']);
            $table->dropIndex(['view_count']);
            $table->dropFullText(['title', 'content']);
        });
    }
};
