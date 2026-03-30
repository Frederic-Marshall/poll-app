@extends('layout.app')

@section('title', 'Профиль ' . $user->nickname)

@section('content')
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
        <span class="text-2xl font-bold text-gray-800 mb-6">Профиль</span>
        @if(auth()->id() === $user->id)
            <a href="{{ route('users.edit', $user) }}"
               class="text-blue-500 underline py-2 rounded-md hover:text-blue-100 transition">
                Редактировать
            </a>
        @endif

        <div class="space-y-2">
            <div class="flex justify-between border-b border-gray-200 py-2">
                <span class="font-medium text-gray-700">Имя:</span>
                <span class="text-gray-800">{{ $user->name }}</span>
            </div>

            <div class="flex justify-between border-b border-gray-200 py-2">
                <span class="font-medium text-gray-700">Никнейм:</span>
                <span class="text-gray-800">{{ $user->nickname }}</span>
            </div>

            <div class="flex justify-between border-b border-gray-200 py-2">
                <span class="font-medium text-gray-700">Email:</span>
                <span class="text-gray-800">{{ $user->email }}</span>
            </div>
        </div>

        @if(auth()->id() === $user->id)
            <div class="mt-6 flex justify-between">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                        Выход
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection
