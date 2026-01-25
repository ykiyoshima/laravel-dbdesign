<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * タグテーブル - 記事に付与するタグ
     * 学習ポイント:
     * - 多対多リレーションの片側
     * - シンプルなマスターテーブル設計
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique(); // タグ名（ユニーク）
            $table->string('slug', 50)->unique(); // URL用スラッグ
            $table->timestamps();
            
            // インデックス: タグ名での検索を高速化
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
