@extends('layout.app')

@section('title', 'Список опросов')

@section('content')
    <div class="max-w-4xl mx-auto space-y-4 mt-6">
        <a href="{{ route('polls.export') }}"
           class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Скачать опросы
        </a>
        @if($polls->isEmpty())
            <p class="text-center text-gray-600">Опросов пока нет.</p>
        @else
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($polls as $poll)
                    <div class="bg-white shadow-md rounded-lg p-4 flex flex-col justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">{{ $poll->title }}</h2>
                            <p class="text-gray-600 mt-1">{{ $poll->description }}</p>
                        </div>
                        <div class="mt-4 text-right">
                            <a href="{{ route('polls.show', $poll) }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                                Перейти
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
