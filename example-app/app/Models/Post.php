<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 記事モデル
 * 
 * リレーション:
 * - user: 多対1 (記事は1人のユーザーに属する)
 * - category: 多対1 (記事は1つのカテゴリに属する)
 * - tags: 多対多 (記事は複数のタグを持ち、タグも複数の記事に属する)
 * - comments: 1対多 (1つの記事に複数のコメント)
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'user_id',
        'category_id',
        'status',
        'published_at',
        'view_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'view_count' => 'integer',
    ];

    /**
     * この記事を書いたユーザーを取得
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この記事が属するカテゴリを取得
     * 
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * この記事に関連付けられたタグを取得
     * 中間テーブル: post_tag
     * 
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)
                    ->withTimestamps(); // 中間テーブルのタイムスタンプも保存
    }

    /**
     * この記事に対するコメントを取得
     * 
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 承認されたコメントのみを取得
     * 
     * @return HasMany
     */
    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)
                    ->where('is_approved', true)
                    ->whereNull('parent_id'); // 親コメントのみ
    }
}
