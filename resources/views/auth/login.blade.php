@extends('layout.app')

@section('title', 'Вход')

@section('content')
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Вход</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" required
                       class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-400 focus:border-blue-400">
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Пароль</label>
                <input type="password" name="password" id="password" required
                       class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-400 focus:border-blue-400">
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-blue-500 text-white font-medium rounded-md p-2 hover:bg-blue-600 transition">
                    Войти
                </button>
            </div>
        </form>

        <div class="mt-4 text-center text-gray-600">
            Нет аккаунта?
            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Зарегистрироваться</a>
        </div>
    </div>
@endsection
