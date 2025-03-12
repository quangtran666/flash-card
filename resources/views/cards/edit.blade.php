@extends('layouts.app')

@section('title', 'Chỉnh sửa thẻ')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('decks.show', $deck->id) }}" class="text-indigo-600 hover:text-indigo-800 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Chỉnh sửa thẻ - {{ $deck->name }}</h1>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('cards.update', $card->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="deck_id" value="{{ $deck->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mặt trước -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Mặt trước</h2>

                        <div class="mb-4">
                            <label for="front_content" class="block text-sm font-medium text-gray-700 mb-1">Từ vựng</label>
                            <input type="text" name="front_content" id="front_content"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4 @error('front_content') border-red-500 @enderror"
                                   value="{{ old('front_content', $card->front_content) }}" required>
                            @error('front_content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="pronunciation" class="block text-sm font-medium text-gray-700 mb-1">Phiên âm</label>
                            <input type="text" name="pronunciation" id="pronunciation"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4 @error('pronunciation') border-red-500 @enderror"
                                   value="{{ old('pronunciation', $card->pronunciation) }}">
                            @error('pronunciation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="image_url" class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh (URL)</label>
                            <input type="url" name="image_url" id="image_url"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4 @error('image_url') border-red-500 @enderror"
                                   value="{{ old('image_url', $card->image_url) }}">
                            @error('image_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Mặt sau -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Mặt sau</h2>

                        <div class="mb-4">
                            <label for="back_content" class="block text-sm font-medium text-gray-700 mb-1">Định nghĩa/Nghĩa</label>
                            <input type="text" name="back_content" id="back_content"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4 @error('back_content') border-red-500 @enderror"
                                   value="{{ old('back_content', $card->back_content) }}" required>
                            @error('back_content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="example" class="block text-sm font-medium text-gray-700 mb-1">Ví dụ</label>
                            <textarea name="example" id="example" rows="4"
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4 @error('example') border-red-500 @enderror">{{ old('example', $card->example) }}</textarea>
                            @error('example')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Xem trước thẻ -->
                <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Xem trước thẻ</h2>

                    <div class="flex justify-center">
                        <div class="w-64 h-40 bg-white border-2 border-gray-300 rounded-lg shadow-md p-4 flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-xl font-bold text-gray-800" id="preview-front">{{ $card->front_content }}</p>
                                <p class="text-sm text-gray-500" id="preview-pronunciation">{{ $card->pronunciation }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('decks.show', $deck->id) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Hủy
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Simple preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const frontInput = document.getElementById('front_content');
            const pronunciationInput = document.getElementById('pronunciation');
            const previewFront = document.getElementById('preview-front');
            const previewPronunciation = document.getElementById('preview-pronunciation');

            frontInput.addEventListener('input', function() {
                previewFront.textContent = this.value || 'Từ vựng';
            });

            pronunciationInput.addEventListener('input', function() {
                previewPronunciation.textContent = this.value || '/phiên âm/';
            });
        });
    </script>
@endsection
