<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <a href="{{route('dashboard')}}" class="text-xl font-bold text-indigo-600">FLASH CARD APP</a>
            <nav>
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{route('dashboard')}}" class="text-gray-800 hover:text-indigo-600">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{route('decks.index')}}" class="text-gray-800 hover:text-indigo-600">Bộ thẻ</a>
                    </li>
                    <li>
                        <a href="{{route('study.index')}}" class="text-gray-800 hover:text-indigo-600">Học tập</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
