@extends('layouts.app')

@section('title', 'Bắt đầu học')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Bắt đầu học</h1>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Chọn bộ thẻ để học</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($decks as $deck)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-colors">
                        <h3 class="font-medium text-gray-800">{{ $deck->name }}</h3>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-sm text-gray-500">{{ $deck->card_count }} thẻ</span>
                            <span class="bg-{{ $deck->level === 'beginner' ? 'green' : ($deck->level == 'intermediate' ? 'yellow' : 'red') }}-100 text-{{ $deck->level === 'beginner' ? 'green' : ($deck->level == 'intermediate' ? 'yellow' : 'red') }}-800 text-xs px-2 py-1 rounded">
                            {{ $deck->level == 'beginner' ? 'Sơ cấp' : ($deck->level == 'intermediate' ? 'Trung cấp' : 'Nâng cao') }}
                        </span>
                        </div>
                        <a href="{{ route('study.flashcard', $deck->id) }}" class="mt-3 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Bắt đầu học
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">Không có bộ thẻ nào. Hãy tạo bộ thẻ trước khi bắt đầu học.</p>
                        <a href="{{ route('decks.create') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Tạo bộ thẻ mới
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Tùy chọn học tập</h2>

            <form>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="card_count" class="block text-sm font-medium text-gray-700 mb-1">Số lượng thẻ mỗi phiên</label>
                        <select name="card_count" id="card_count"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4">
                            <option value="10">10 thẻ</option>
                            <option value="20">20 thẻ</option>
                            <option value="30">30 thẻ</option>
                            <option value="all">Tất cả</option>
                        </select>
                    </div>

                    <div>
                        <label for="display_mode" class="block text-sm font-medium text-gray-700 mb-1">Chế độ hiển thị</label>
                        <select name="display_mode" id="display_mode"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4">
                            <option value="front_first">Từ vựng trước</option>
                            <option value="back_first">Nghĩa trước</option>
                            <option value="random">Ngẫu nhiên</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
