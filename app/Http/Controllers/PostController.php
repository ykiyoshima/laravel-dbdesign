<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * ブログトップページ - 公開済み記事一覧
     * 検索・フィルタ・ソート機能付き
     */
    public function index(Request $request)
    {
        // クエリビルダーの初期化
        $query = Post::with(['user', 'category', 'tags'])
            ->where('status', 'published');

        // キーワード検索（日本語対応）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            // 日本語検索に対応するためLIKE検索を使用
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('content', 'LIKE', "%{$keyword}%");
            });
        }

        // カテゴリフィルタ（複数選択）
        if ($request->filled('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        // タグフィルタ（複数選択、OR条件）
        if ($request->filled('tags')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('tags.id', $request->tags);
            });
        }

        // ソート（デフォルト: 投稿日降順）
        $sortBy = $request->input('sort', 'published_at');
        if ($sortBy === 'view_count') {
            $query->orderBy('view_count', 'desc');
        } else {
            $query->orderBy('published_at', 'desc');
        }

        // ページネーション
        $posts = $query->paginate(10);

        // カテゴリとタグも一緒に取得
        $categories = Category::withCount('posts')->get();
        $tags = Tag::withCount('posts')->get();

        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    /**
     * 記事詳細ページ
     */
    public function show(Post $post)
    {
        // Eager Loadingでリレーションを取得
        $post->load([
            'user',
            'category',
            'tags',
            'approvedComments.user',
            'approvedComments.approvedReplies.user'
        ]);

        // 閲覧数をカウント
        $post->increment('view_count');

        return view('posts.show', compact('post'));
    }

    /**
     * カテゴリ別記事一覧
     */
    public function byCategory(Category $category)
    {
        $posts = $category->posts()
            ->with(['user', 'tags'])
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $categories = Category::withCount('posts')->get();
        $tags = Tag::withCount('posts')->get();

        return view('posts.category', compact('posts', 'category', 'categories', 'tags'));
    }

    /**
     * タグ別記事一覧
     */
    public function byTag(Tag $tag)
    {
        $posts = $tag->posts()
            ->with(['user', 'category'])
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $categories = Category::withCount('posts')->get();
        $tags = Tag::withCount('posts')->get();

        return view('posts.tag', compact('posts', 'tag', 'categories', 'tags'));
    }
}
