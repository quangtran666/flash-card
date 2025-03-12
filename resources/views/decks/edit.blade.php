@extends('layouts.app')

@section('title', 'Chỉnh sửa bộ thẻ')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('decks.index') }}" class="text-indigo-600 hover:text-indigo-800 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Chỉnh sửa bộ thẻ</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('decks.update', $deck->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên bộ thẻ</label>
                    <input type="text" name="name" id="name"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4 @error('name') border-red-500 @enderror"
                           value="{{ old('name', $deck->name) }}" required>
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                    <textarea name="description" id="description" rows="3"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4 @error('description') border-red-500 @enderror">{{ old('description', $deck->description) }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 mb-1">Ngôn ngữ</label>
                        <select name="language" id="language"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4 @error('language') border-red-500 @enderror">
                            <option value="english" {{ (old('language', $deck->language) === 'english') ? 'selected' : '' }}>Tiếng Anh</option>
                            <option value="vietnamese" {{ (old('language', $deck->language) === 'vietnamese') ? 'selected' : '' }}>Tiếng Việt</option>
                            <option value="japanese" {{ (old('language', $deck->language) === 'japanese') ? 'selected' : '' }}>Tiếng Nhật</option>
                            <option value="korean" {{ (old('language', $deck->language) === 'korean') ? 'selected' : '' }}>Tiếng Hàn</option>
                            <option value="french" {{ (old('language', $deck->language) === 'french') ? 'selected' : '' }}>Tiếng Pháp</option>
                            <option value="chinese" {{ (old('language', $deck->language) === 'chinese') ? 'selected' : '' }}>Tiếng Trung</option>
                        </select>
                        @error('language')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Cấp độ</label>
                        <select name="level" id="level"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4 @error('level') border-red-500 @enderror">
                            <option value="beginner" {{ (old('level', $deck->level) === 'beginner') ? 'selected' : '' }}>Sơ cấp</option>
                            <option value="intermediate" {{ (old('level', $deck->level) === 'intermediate') ? 'selected' : '' }}>Trung cấp</option>
                            <option value="advanced" {{ (old('level', $deck->level) === 'advanced') ? 'selected' : '' }}>Nâng cao</option>
                        </select>
                        @error('level')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('decks.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Hủy
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
