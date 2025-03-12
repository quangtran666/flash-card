@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

        <!-- Các hành động chính -->
        <div class="bg-white shadow rounded p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Thao tác nhanh</h2>
            <div class="flex space-x-4">
                <a href="/decks/create" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Tạo bộ thẻ mới</a>
                <a href="/study" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Bắt đầu học</a>
            </div>
        </div>

        <!-- Thông tin cơ bản -->
        <div class="bg-white shadow rounded p-6">
            <h2 class="text-lg font-semibold mb-4">Thông tin tổng quan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="border rounded p-4 text-center">
                    <p class="text-gray-600">Bộ thẻ</p>
                    <p class="text-2xl font-bold">{{ $totalDecks }}</p>
                </div>
                <div class="border rounded p-4 text-center">
                    <p class="text-gray-600">Thẻ học</p>
                    <p class="text-2xl font-bold">{{ $totalCards }}</p>
                </div>
                <div class="border rounded p-4 text-center">
                    <p class="text-gray-600">Đã học</p>
                    <p class="text-2xl font-bold">{{ $totalStudySessions }}</p>
                </div>
            </div>
        </div>

    </div>
@endsection
