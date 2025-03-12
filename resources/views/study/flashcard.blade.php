@extends('layouts.app')

@section('title', 'Học từ vựng')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('study.index') }}" class="text-indigo-600 hover:text-indigo-800 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Học bộ thẻ: {{ $deck->name }}</h1>
        </div>

        <!-- Progress Bar -->
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-6">
            <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($currentCardIndex / $totalCards) * 100 }}%"></div>
        </div>
        <div class="flex justify-between text-sm text-gray-500 mb-6">
            <span>Thẻ {{ $currentCardIndex }}/{{ $totalCards }}</span>
            <span>{{ round(($currentCardIndex / $totalCards) * 100) }}% hoàn thành</span>
        </div>

        <!-- Flashcard -->
        <div class="flex justify-center mb-10">
            <div class="w-full max-w-lg">
                <div class="flip-card cursor-pointer" data-id="{{ $currentCard->id }}">
                    <div class="flip-card-inner bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                        <!-- Front -->
                        <div class="flip-card-front flex flex-col items-center justify-center">
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $currentCard->front_content }}</h2>
                            <p class="text-gray-500 text-lg mb-4">{{ $currentCard->pronunciation ?? '' }}</p>
                            <p class="text-gray-400 text-sm">Nhấp vào để lật thẻ</p>
                        </div>

                        <!-- Back -->
                        <div class="flip-card-back flex flex-col items-center justify-center bg-gray-50">
                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $currentCard->back_content }}</h2>
                            @if($currentCard->example)
                                <div class="bg-white rounded p-3 w-full">
                                    <p class="text-gray-700"><span class="font-medium">Ví dụ:</span> {{ $currentCard->example }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <div class="flex flex-col items-center">
            <div class="text-center mb-6">
                <p class="text-gray-600 mb-2">Mức độ nhớ của bạn?</p>
                <div class="flex space-x-4">
                    <button class="rating-btn px-5 py-2 bg-red-100 hover:bg-red-200 text-red-800 rounded-md transition-colors" data-rating="1" data-card-id="{{ $currentCard->id }}" data-session-id="{{ $studySession->id }}">
                        Khó
                    </button>
                    <button class="rating-btn px-5 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 rounded-md transition-colors" data-rating="2" data-card-id="{{ $currentCard->id }}" data-session-id="{{ $studySession->id }}">
                        Vừa
                    </button>
                    <button class="rating-btn px-5 py-2 bg-green-100 hover:bg-green-200 text-green-800 rounded-md transition-colors" data-rating="3" data-card-id="{{ $currentCard->id }}" data-session-id="{{ $studySession->id }}">
                        Dễ
                    </button>
                </div>
            </div>

            <div class="flex space-x-4">
                <button id="prevBtn" class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 {{ $currentCardIndex == 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $currentCardIndex == 1 ? 'disabled' : '' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Thẻ trước
                </button>
                <button id="nextBtn" class="flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Thẻ tiếp theo
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <style>
        .flip-card {
            perspective: 1000px;
            height: 300px;
        }
        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }
        .flip-card:hover .flip-card-inner,
        .flip-card.flipped .flip-card-inner {
            transform: rotateY(180deg);
        }
        .flip-card-front, .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 0.75rem;
        }
        .flip-card-back {
            transform: rotateY(180deg);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flipCard = document.querySelector('.flip-card');
            const ratingButtons = document.querySelectorAll('.rating-btn');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const progressBar = document.querySelector('.bg-indigo-600');
            const currentCardText = document.querySelector('span:first-child');
            const progressText = document.querySelector('span:last-child');
            let currentCardId = "{{ $currentCard->id }}";
            let studySessionId = "{{ $studySession->id }}";

            // Toggle card flip
            flipCard.addEventListener('click', function() {
                this.classList.toggle('flipped');
            });

            // Handle rating
            ratingButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const rating = this.dataset.rating;
                    const cardId = this.dataset.cardId;
                    const sessionId = this.dataset.sessionId;

                    // Disable all rating buttons after one is clicked
                    ratingButtons.forEach(b => b.disabled = true);

                    // Send rating to server
                    fetch('{{ route("study.rate") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            card_id: cardId,
                            rating: rating,
                            study_session_id: sessionId
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.completed) {
                                // Redirect to results page
                                window.location.href = data.redirect_url;
                            } else {
                                // Update the card content
                                currentCardId = data.card.id;

                                // Update the front of the card
                                const frontContent = flipCard.querySelector('.flip-card-front h2');
                                const pronunciation = flipCard.querySelector('.flip-card-front p:first-of-type');
                                frontContent.textContent = data.card.front_content;
                                pronunciation.textContent = data.card.pronunciation || '';

                                // Update the back of the card
                                const backContent = flipCard.querySelector('.flip-card-back h2');
                                const example = flipCard.querySelector('.flip-card-back .bg-white p');
                                backContent.textContent = data.card.back_content;

                                if (data.card.example) {
                                    if (example) {
                                        example.innerHTML = '<span class="font-medium">Ví dụ:</span> ' + data.card.example;
                                    } else {
                                        const exampleDiv = document.createElement('div');
                                        exampleDiv.className = 'bg-white rounded p-3 w-full';
                                        exampleDiv.innerHTML = `<p class="text-gray-700"><span class="font-medium">Ví dụ:</span> ${data.card.example}</p>`;
                                        flipCard.querySelector('.flip-card-back').appendChild(exampleDiv);
                                    }
                                } else if (example) {
                                    example.parentElement.remove();
                                }

                                // Update progress
                                progressBar.style.width = data.progress_percent + '%';
                                currentCardText.textContent = `Thẻ ${data.current_index}/${data.total}`;
                                progressText.textContent = `${data.progress_percent}% hoàn thành`;

                                // Update card ID in flip card and buttons
                                flipCard.dataset.id = data.card.id;
                                ratingButtons.forEach(b => {
                                    b.dataset.cardId = data.card.id;
                                });

                                // Reset card flip
                                flipCard.classList.remove('flipped');

                                // Enable rating buttons again
                                ratingButtons.forEach(b => b.disabled = false);

                                // Update previous button state
                                prevBtn.disabled = data.current_index === 1;
                                prevBtn.classList.toggle('opacity-50', data.current_index === 1);
                                prevBtn.classList.toggle('cursor-not-allowed', data.current_index === 1);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Re-enable buttons on error
                            ratingButtons.forEach(b => b.disabled = false);
                        });
                });
            });

            // Handle next button
            nextBtn.addEventListener('click', function() {
                // Simply trigger the "easy" rating
                document.querySelector('.rating-btn[data-rating="3"]').click();
            });

            // Previous card function would require additional backend support
            // This is simplified and would need more work for a full implementation
            prevBtn.addEventListener('click', function() {
                if (prevBtn.disabled) return;

                // This would need server-side support to get the previous card
                alert('Feature to go back to previous card is not yet implemented');
            });
        });
    </script>
@endsection
