<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * カテゴリテーブル - 記事を分類するための基本テーブル
     * 学習ポイント:
     * - 基本的なテーブル構造
     * - プライマリキー（id）
     * - ユニーク制約（slug）
     * - インデックス（nameフィールド）
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // 主キー（AUTO_INCREMENT）
            $table->string('name', 100); // カテゴリ名
            $table->string('slug', 100)->unique(); // URL用スラッグ（ユニーク制約）
            $table->text('description')->nullable(); // カテゴリの説明
            $table->timestamps(); // created_at, updated_at
            
            // インデックス: 名前での検索を高速化
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
