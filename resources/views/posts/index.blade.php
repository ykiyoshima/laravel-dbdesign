@extends('layouts.app')

@section('title', '記事一覧 - Tech Blog')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- メインコンテンツ -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">📝 記事一覧</h1>
            <p class="text-gray-600">最新の技術記事をチェックしよう</p>
        </div>

        <!-- 検索フォーム (スマホ表示用) -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 lg:hidden">
            <form method="GET" action="{{ route('home') }}" class="space-y-4">
                <!-- キーワード検索 -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        🔍 キーワード検索
                    </label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" 
                           placeholder="記事のタイトルや本文から検索"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- カテゴリ選択 -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📁 カテゴリ
                    </label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($categories as $category)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                   {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">{{ $category->name }} ({{ $category->posts_count }})</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- タグ選択 -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        🏷️ タグ
                    </label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($tags as $tag)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                   {{ in_array($tag->id, request('tags', [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">#{{ $tag->name }} ({{ $tag->posts_count }})</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- ソート選択 -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📊 並び順
                    </label>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="sort" value="published_at"
                                   {{ request('sort', 'published_at') === 'published_at' ? 'checked' : '' }}
                                   class="border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">📅 投稿日順</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="sort" value="view_count"
                                   {{ request('sort') === 'view_count' ? 'checked' : '' }}
                                   class="border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">👁 閲覧数順</span>
                        </label>
                    </div>
                </div>

                <!-- 検索ボタン -->
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        検索
                    </button>
                    <a href="{{ route('home') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                        クリア
                    </a>
                </div>
            </form>
        </div>

        @forelse($posts as $post)
        <article class="bg-white rounded-lg shadow-md p-6 mb-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-3">
                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                    {{ $post->category?->name ?? 'カテゴリなし' }}
                </span>
                <span class="text-sm text-gray-500">
                    👁 {{ $post->view_count }} views
                </span>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600">
                    {{ $post->title }}
                </a>
            </h2>

            <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>

            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center space-x-4">
                    <span class="text-gray-500">✍️ {{ $post->user->name }}</span>
                    <span class="text-gray-500">📅 {{ $post->published_at->format('Y/m/d') }}</span>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                    <a href="{{ route('tags.show', $tag->slug) }}" 
                       class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded hover:bg-gray-300">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </article>
        @empty
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-500">記事がまだありません</p>
        </div>
        @endforelse

        <!-- ページネーション -->
        <div class="mt-6">
            {{ $posts->appends(request()->except('page'))->links() }}
        </div>
    </div>

    <!-- サイドバー -->
    <div class="lg:col-span-1">
        <!-- 検索フォーム (デスクトップ表示用) -->
        <div class="hidden lg:block bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">🔍 検索・絞り込み</h3>
            <form method="GET" action="{{ route('home') }}" class="space-y-4">
                <!-- キーワード検索 -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        キーワード検索
                    </label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" 
                           placeholder="記事のタイトルや本文から検索"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- カテゴリ選択 -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📁 カテゴリ
                    </label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($categories as $category)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                   {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">{{ $category->name }} ({{ $category->posts_count }})</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- タグ選択 -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        🏷️ タグ
                    </label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($tags as $tag)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                   {{ in_array($tag->id, request('tags', [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">#{{ $tag->name }} ({{ $tag->posts_count }})</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- ソート選択 -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📊 並び順
                    </label>
                    <div class="flex flex-col gap-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="sort" value="published_at"
                                   {{ request('sort', 'published_at') === 'published_at' ? 'checked' : '' }}
                                   class="border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">📅 投稿日順</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="sort" value="view_count"
                                   {{ request('sort') === 'view_count' ? 'checked' : '' }}
                                   class="border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">👁 閲覧数順</span>
                        </label>
                    </div>
                </div>

                <!-- 検索ボタン -->
                <div class="flex flex-col gap-2">
                    <button type="submit" class="w-full px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        検索
                    </button>
                    <a href="{{ route('home') }}" class="w-full text-center px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                        クリア
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
