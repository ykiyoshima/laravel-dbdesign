<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * 中間テーブル（ピボットテーブル） - 記事とタグの多対多リレーション
     * 学習ポイント:
     * - 多対多リレーション（Many to Many）
     * - 中間テーブルの設計
     * - 複合主キー
     * - 外部キー制約
     */
    public function up(): void
    {
        Schema::create('post_tag', function (Blueprint $table) {
            // 外部キー: 記事
            $table->foreignId('post_id')
                  ->constrained('posts')
                  ->onDelete('cascade');
            
            // 外部キー: タグ
            $table->foreignId('tag_id')
                  ->constrained('tags')
                  ->onDelete('cascade');
            
            // 複合主キー: 同じ組み合わせの重複を防ぐ
            $table->primary(['post_id', 'tag_id']);
            
            // タイムスタンプ（中間テーブルでも追加情報を持つことが可能）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tag');
    }
};
