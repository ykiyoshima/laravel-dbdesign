<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tech Blog')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div>
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                        📝 Tech Blog
                    </a>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">ホーム</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white mt-16 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-sm">© 2026 Tech Blog. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
