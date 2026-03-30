@extends('layout.app')

@section('title', 'Редактирование пользователя')

@section('content')
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Редактирование профиля</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('users.update', $user) }}"
              x-data="{ saving: false }" @submit="saving = true" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Имя</label>
                <input type="text" name="name" id="name" required
                       value="{{ old('name', $user->name) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-400 focus:border-blue-400">
                @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="nickname" class="block text-gray-700 font-medium mb-1">Никнейм</label>
                <input type="text" name="nickname" id="nickname" required
                       value="{{ old('nickname', $user->nickname) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-400 focus:border-blue-400">
                @error('nickname')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" required
                       value="{{ old('email', $user->email) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-400 focus:border-blue-400">
                @error('email')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ url()->previous() }}"
                   class="text-gray-600 hover:underline">
                    Назад
                </a>

                <button type="submit"
                        :disabled="saving"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="! saving">Сохранить</span>
                    <span x-show="saving">Сохраняем...</span>
                </button>
            </div>
        </form>
    </div>
@endsection
