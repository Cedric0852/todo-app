<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Todo App' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
<header class="border-b">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
    <a href="{{ route('todos.index') }}" class="font-semibold">Todo App</a>
    <nav class="flex items-center gap-3">
        @auth
            <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="px-3 py-1.5 rounded-md border text-sm">Logout</button>
            </form>
        @else
            <a class="px-3 py-1.5 rounded-md border text-sm" href="{{ route('login') }}">Login</a>
            <a class="px-3 py-1.5 rounded-md bg-gray-900 text-white text-sm rounded-md" href="{{ route('register') }}">Register</a>
        @endauth
    </nav>
    </div>
</header>
<main class="max-w-3xl mx-auto px-4 py-6">
    @if (session('status'))
        <div class="px-3 py-2 mb-3 rounded-md border border-emerald-200 bg-emerald-50 text-emerald-800">{{ session('status') }}</div>
    @endif
    {{ $slot ?? '' }}
    @yield('content')
</main>
</body>
</html>
