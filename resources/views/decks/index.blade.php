@extends('layouts.app')

@section('title', 'Bộ thẻ học từ vựng')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Bộ thẻ học từ vựng</h1>
            <a href="{{ route('decks.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tạo bộ thẻ mới
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($decks as $deck)
                <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow p-6">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $deck->name }}</h2>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $deck->language }}</span>
                    </div>

                    <p class="text-gray-600 mt-2 line-clamp-2">{{ $deck->description }}</p>

                    <div class="flex items-center mt-4">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                        {{ $deck->level }}
                    </span>
                        <span class="ml-2 text-gray-500 text-sm">
                        {{ $deck->cards_count }} thẻ
                    </span>
                    </div>

                    <div class="flex justify-between mt-6">
                        <a href="{{ route('decks.show', $deck->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            Xem chi tiết
                        </a>
                        <div class="flex space-x-2">
                            <a href="{{ route('decks.edit', $deck->id) }}" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                            <form action="{{ route('decks.destroy', $deck->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bộ thẻ này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-600">Chưa có bộ thẻ nào. Hãy tạo bộ thẻ đầu tiên của bạn!</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
