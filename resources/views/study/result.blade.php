@extends('layouts.app')

@section('title', 'Kết quả học tập')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('study.index') }}" class="text-indigo-600 hover:text-indigo-800 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Kết quả học tập</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-green-100 text-green-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800 mb-1">Hoàn thành phiên học!</h2>
                <p class="text-gray-600">{{ $studySession->deck->name }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <h3 class="text-lg font-medium text-gray-800">Tổng số thẻ</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $studySession->cards_studied }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <h3 class="text-lg font-medium text-gray-800">Dễ nhớ</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $studySession->easy_count }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <h3 class="text-lg font-medium text-gray-800">Cần ôn tập</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $studySession->medium_count + $studySession->hard_count }}</p>
                </div>
            </div>
        </div>

        @if($cardsToReview->count() > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-800 mb-4">Thẻ cần ôn tập lại</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($cardsToReview as $card)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <p class="font-medium text-gray-800 mb-1">{{ $card->front_content }}</p>
                            <p class="text-gray-600">{{ $card->back_content }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-center mt-6 space-x-4">
                    <a href="{{ route('study.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Trở về trang chọn bộ thẻ
                    </a>
                    <a href="{{ route('study.flashcard', $studySession->deck_id) }}" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Học lại bộ thẻ này
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
