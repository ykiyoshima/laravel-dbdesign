<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * コメントモデル
 * 
 * リレーション:
 * - post: 多対1 (コメントは1つの記事に属する)
 * - user: 多対1 (コメントは1人のユーザーに属する、NULLable)
 * - parent: 多対1 (返信コメントは親コメントに属する、自己参照)
 * - replies: 1対多 (1つのコメントに複数の返信)
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'guest_name',
        'guest_email',
        'content',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * このコメントが属する記事を取得
     * 
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * このコメントを書いたユーザーを取得（NULLable）
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 親コメントを取得（自己参照リレーション）
     * 
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * このコメントに対する返信を取得
     * 
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * 承認された返信のみを取得
     * 
     * @return HasMany
     */
    public function approvedReplies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')
                    ->where('is_approved', true);
    }
}
