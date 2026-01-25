<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * タグモデル
 * 
 * リレーション:
 * - posts: 多対多 (タグは複数の記事に属し、記事も複数のタグを持つ)
 */
class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * このタグが付けられた記事を取得
     * 中間テーブル: post_tag
     * 
     * @return BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class)
                    ->withTimestamps();
    }
}
