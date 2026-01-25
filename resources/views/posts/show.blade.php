@extends('layouts.app')

@section('title', $post->title . ' - Tech Blog')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- 記事本文 -->
    <div class="lg:col-span-2">
        <article class="bg-white rounded-lg shadow-md p-8">
            <!-- カテゴリとステータス -->
            <div class="flex items-center gap-3 mb-4">
                @if($post->category)
                <a href="{{ route('categories.show', $post->category->slug) }}" 
                   class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm hover:bg-blue-200">
                    {{ $post->category->name }}
                </a>
                @endif
                <span class="text-gray-500 text-sm">👁 {{ $post->view_count }} views</span>
            </div>

            <!-- タイトル -->
            <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $post->title }}</h1>

            <!-- メタ情報 -->
            <div class="flex items-center space-x-4 text-sm text-gray-600 mb-6 pb-6 border-b">
                <span class="flex items-center">✍️ {{ $post->user->name }}</span>
                <span class="flex items-center">📅 {{ $post->published_at->format('Y年m月d日') }}</span>
            </div>

            <!-- 抜粋 -->
            @if($post->excerpt)
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <p class="text-gray-700">{{ $post->excerpt }}</p>
            </div>
            @endif

            <!-- 本文 -->
            <div class="prose max-w-none text-gray-700 leading-relaxed mb-6">
                {!! nl2br(e($post->content)) !!}
            </div>

            <!-- タグ -->
            @if($post->tags->count() > 0)
            <div class="pt-6 border-t">
                <h3 class="text-sm font-semibold text-gray-600 mb-3">🏷️ タグ:</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                    <a href="{{ route('tags.show', $tag->slug) }}" 
                       class="bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-blue-500 hover:text-white transition">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </article>

        <!-- コメントセクション -->
        <div class="bg-white rounded-lg shadow-md p-8 mt-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                💬 コメント ({{ $post->approvedComments->count() }})
            </h2>

            @forelse($post->approvedComments as $comment)
            <div class="mb-6 pb-6 border-b last:border-b-0">
                <!-- 親コメント -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                        {{ $comment->user ? mb_substr($comment->user->name, 0, 1) : '?' }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="font-semibold text-gray-800">
                                {{ $comment->user?->name ?? $comment->guest_name }}
                            </span>
                            @if(!$comment->user)
                            <span class="bg-gray-200 text-gray-600 text-xs px-2 py-1 rounded">ゲスト</span>
                            @endif
                            <span class="text-sm text-gray-500">
                                {{ $comment->created_at->format('Y/m/d H:i') }}
                            </span>
                        </div>
                        <p class="text-gray-700">{{ $comment->content }}</p>
                    </div>
                </div>

                <!-- 返信コメント（自己参照リレーション） -->
                @if($comment->approvedReplies->count() > 0)
                <div class="ml-14 mt-4 space-y-4">
                    @foreach($comment->approvedReplies as $reply)
                    <div class="flex items-start space-x-4 bg-gray-50 p-4 rounded">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            {{ $reply->user ? mb_substr($reply->user->name, 0, 1) : '?' }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="font-semibold text-gray-800 text-sm">
                                    {{ $reply->user?->name ?? $reply->guest_name }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ $reply->created_at->format('Y/m/d H:i') }}
                                </span>
                                <span class="text-xs text-blue-600">↩️ 返信</span>
                            </div>
                            <p class="text-gray-700 text-sm">{{ $reply->content }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @empty
            <p class="text-gray-500 text-center py-8">まだコメントがありません</p>
            @endforelse
        </div>
    </div>

    <!-- サイドバー -->
    <div class="lg:col-span-1">
        <!-- 著者情報 -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">✍️ 著者</h3>
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                    {{ mb_substr($post->user->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ $post->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $post->user->posts->count() }}件の記事</p>
                </div>
            </div>
        </div>

        <!-- 最近の記事 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">📰 最近の記事</h3>
            <div class="space-y-3">
                @foreach($post->user->posts->take(5) as $recentPost)
                    @if($recentPost->id !== $post->id)
                    <a href="{{ route('posts.show', $recentPost->slug) }}" 
                       class="block text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 p-2 rounded transition">
                        {{ $recentPost->title }}
                    </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
