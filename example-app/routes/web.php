<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// ブログアプリケーション

// ホーム：記事一覧
Route::get('/', [PostController::class, 'index'])->name('home');

// 記事詳細
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// カテゴリ別記事一覧
Route::get('/categories/{category:slug}', [PostController::class, 'byCategory'])->name('categories.show');

// タグ別記事一覧
Route::get('/tags/{tag:slug}', [PostController::class, 'byTag'])->name('tags.show');

