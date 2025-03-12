<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudyRateRequest;
use App\Models\Card;
use App\Models\CardProgress;
use App\Models\Deck;
use App\Models\StudySession;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StudyController extends Controller
{
    /**
     * Display list of decks available for studying.
     *
     * @return View
     */
    public function index() : View
    {
        $decks = Deck::withCount('cards')->get();

        return view('study.index', compact('decks'));
    }

    /**
     * Show the flashcard study interface for a specific deck.
     *
     * @param  int  $deck_id
     * @return View|RedirectResponse
     */
    public function flashcard($deck_id) : View | RedirectResponse
    {
        $deck = Deck::with('cards')->findOrFail($deck_id);

        // Check if deck has cards
        if ($deck?->cards->isEmpty()) {
            return redirect()->route('study.index')
                ->with('error', 'Bộ thẻ này chưa có thẻ nào, vui lòng thêm thẻ trước khi học.');
        }

        // Start a new study session or continue an existing one
        $studySession = DB::transaction(static function () use ($deck) {
            return StudySession::firstOrCreate(
                ['deck_id' => $deck->id],
                [
                    'start_time' => now(),
                    'end_time' => now(),
                    'cards_studied' => 0,
                    'easy_count' => 0,
                    'medium_count' => 0,
                    'hard_count' => 0,
                ]
            );
        });

        $currentCard = $deck?->cards->first();
        $totalCards = $deck?->cards->count();
        $currentCardIndex = 1;

        return view('study.flashcard', compact('deck', 'currentCard', 'studySession', 'totalCards', 'currentCardIndex'));
    }

    /**
     * Process user's rating of a card and provide the next card.
     *
     * @param  StudyRateRequest  $request
     * @return JsonResponse
     */
    public function rate(StudyRateRequest $request) : JsonResponse
    {
        $cardId = $request->card_id;
        $rating = $request->rating;
        $studySessionId = $request->study_session_id;

        $card = Card::findOrFail($cardId);
        $studySession = StudySession::findOrFail($studySessionId);
        $deck = $studySession->deck;

        // Use transaction to ensure data integrity
        DB::transaction(function () use ($card, $rating, $studySession) {
            CardProgress::create([
                'card_id' => $card->id,
                'study_session_id' => $studySession->id,
                'familiarity_level' => $rating,
                'review_count' => 1,
                'next_review_date' => $this->calculateNextReviewDate($rating),
            ]);

            ++$studySession->cards_studied;

            switch ($rating) {
                case 1: // Hard
                    ++$studySession->hard_count;
                    break;
                case 2: // Medium
                    ++$studySession->medium_count;
                    break;
                case 3: // Easy
                    ++$studySession->easy_count;
                    break;
            }

            $studySession->save();
        });

        $currentCardIndex = $studySession->cards_studied + 1;
        $totalCards = $deck->cards->count();

        // Check if we've studied all cards
        if ($currentCardIndex > $totalCards) {
            // Complete the study session
            $studySession->end_time = now();
            $studySession->save();

            return response()->json([
                'completed' => true,
                'redirect_url' => route('study.result', $studySession->id)
            ]);
        }

        $nextCard = $deck->cards->skip($currentCardIndex - 1)->first();

        return response()->json([
            'completed' => false,
            'current_index' => $currentCardIndex,
            'total' => $totalCards,
            'progress_percent' => round(($currentCardIndex / $totalCards) * 100),
            'card' => [
                'id' => $nextCard->id,
                'front_content' => $nextCard->front_content,
                'back_content' => $nextCard->back_content,
                'pronunciation' => $nextCard->pronunciation,
                'example' => $nextCard->example,
                'image_url' => $nextCard->image_url,
            ]
        ]);
    }

    /**
     * Show the results after completing a study session.
     *
     * @param  int  $session_id
     * @return View
     */
    public function result($session_id) : View
    {
        $studySession = StudySession::with(['deck', 'cardProgress.card'])->findOrFail($session_id);

        $cardsToReview = $studySession?->cardProgress()
            ->whereIN('familiarity_level', [1, 2])
            ->with('card')
            ->get()
            ->pluck('card');

        // Logic hiển thị kết quả học tập
        return view('study.result', compact('studySession', 'cardsToReview'));
    }

    /**
     * Calculate the next review date based on the familiarity level.
     *
     * @param  int  $familiarityLevel
     * @return Carbon
     */
    private function calculateNextReviewDate(int $familiarityLevel): Carbon
    {
        // Simple SRS algorithm
        return match ($familiarityLevel) {
            1 => Carbon::now()->addDay(),
            2 => Carbon::now()->addDays(3),
            3 => Carbon::now()->addDays(7),
            default => Carbon::now()->addDays(1),
        };
    }
}
