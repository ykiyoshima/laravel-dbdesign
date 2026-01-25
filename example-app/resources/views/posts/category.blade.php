@extends('layouts.app')

@section('title', $category->name . 'の記事 - Tech Blog')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex items-center space-x-3 mb-3">
        <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-lg font-semibold">
            📁 {{ $category->name }}
        </span>
        <span class="text-gray-500">{{ $posts->total() }}件の記事</span>
    </div>
    @if($category->description)
    <p class="text-gray-600">{{ $category->description }}</p>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        @forelse($posts as $post)
        <article class="bg-white rounded-lg shadow-md p-6 mb-6 hover:shadow-lg transition">
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
                    <span class="text-gray-500">👁 {{ $post->view_count }}</span>
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
            <p class="text-gray-500">このカテゴリにはまだ記事がありません</p>
        </div>
        @endforelse

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">📁 カテゴリ一覧</h3>
            <ul class="space-y-2">
                @foreach($categories as $cat)
                <li>
                    <a href="{{ route('categories.show', $cat->slug) }}" 
                       class="flex justify-between items-center text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-3 py-2 rounded {{ $cat->id === $category->id ? 'bg-blue-100 font-semibold' : '' }}">
                        <span>{{ $cat->name }}</span>
                        <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded">
                            {{ $cat->posts_count }}
                        </span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">🏷️ タグ</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                <a href="{{ route('tags.show', $tag->slug) }}" 
                   class="bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-blue-500 hover:text-white transition">
                    #{{ $tag->name }} ({{ $tag->posts_count }})
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
