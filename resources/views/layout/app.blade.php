<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Live-опросы')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-gray-900 text-gray-200">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">
            <div class="flex lg:flex-1">
                <a href="{{ route('home') }}" class="text-xl font-bold text-white hover:text-blue-400 transition-colors">
                    Live
                </a>
            </div>

            <div class="hidden lg:flex lg:gap-6">
                <a href="{{ route('chats.index') }}" class="hover:text-blue-400 transition-colors">Чаты</a>
                <a href="{{ route('polls.index') }}" class="hover:text-blue-400 transition-colors">Список опросов</a>
                @auth
                    <a href="{{ route('users.show', auth()->user()) }}" class="hover:text-blue-400 transition-colors">Профиль</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-blue-400 transition-colors">Вход</a>
                @endauth
            </div>

            <div class="flex lg:hidden">
                <button type="button" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:text-white hover:bg-gray-800 transition">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <main class="flex-1 container mx-auto p-6">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
