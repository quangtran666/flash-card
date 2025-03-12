<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Deck;
use App\Models\StudySession;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalDecks = Deck::count();
        $totalCards = Card::count();
        $totalStudySessions = StudySession::count();

        return view('dashboard.index', compact('totalDecks', 'totalCards', 'totalStudySessions'));
    }
}
