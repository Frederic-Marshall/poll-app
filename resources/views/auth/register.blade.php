@extends('layout.app')

@section('title', 'Регистрация')

@section('content')
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Регистрация</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Имя</label>
                <input type="text" name="name" id="name" required
                       class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-400 focus:border-blue-400">
            </div>

            <div>
                <label for="nickname" class="block text-gray-700 font-medium mb-1">Никнейм</label>
                <input type="text" name="nickname" id="nickname" required
                       class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-400 focus:border-blue-400">
            </div>

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
                    Зарегистрироваться
                </button>
            </div>
        </form>

        <div class="mt-4 text-center text-gray-600">
            Уже есть аккаунт?
            <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Войти</a>
        </div>
    </div>
@endsection
