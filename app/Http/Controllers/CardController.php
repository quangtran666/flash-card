<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardRequest;
use App\Models\Card;
use App\Models\Deck;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        return view('cards.index');
    }

    /**
     * Show the form for creating a new card.
     *
     * @param  int  $deck_id
     * @return View
     */
    public function create() : View
    {
        $deck_id = request('deck_id');
        $deck = Deck::findOrFail($deck_id);

        return view('cards.create', compact('deck'));
    }

    /**
     * Store a newly created card in storage.
     *
     * @param  CardRequest  $request
     * @return RedirectResponse
     */
    public function store(CardRequest $request) : RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $card = Card::create($request->validated());

            $deck = Deck::findOrFail($request->deck_id);
            $deck->increment('card_count');
        });

        return redirect()->route('decks.show', $request->deck_id)
            ->with('success', 'Deck created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('cards.show');
    }

    /**
     * Show the form for editing the specified card.
     *
     * @param  Card  $card
     * @return View
     */
    public function edit(Card $card) : View
    {
        $deck = $card->deck;

        return view('cards.edit', compact('card', 'deck'));
    }

    /**
     * Update the specified card in storage.
     *
     * @param  CardRequest  $request
     * @param  Card  $card
     * @return RedirectResponse
     */
    public function update(CardRequest $request, Card $card) : RedirectResponse
    {
        // Ensure the card is being updated within the same deck
        if ($request->deck_id != $card->deck_id) {
            return back()->with('error', 'Cannot update card in a different deck!');
        }

        DB::transaction(static function () use ($request, $card) {
            $card->update($request->validated());
        });

        return redirect()->route('decks.show', $request->deck_id)
            ->with('success', 'Thẻ đã được cập nhật thành công!');
    }

    /**
     * Remove the specified card from storage.
     *
     * @param  Card  $card
     * @return RedirectResponse
     */
    public function destroy(Card $card) : RedirectResponse
    {
        $deck_id = $card->deck_id;

        DB::transaction(static function () use ($card, $deck_id) {
           $card->delete();

           $deck = Deck::findOrFail($deck_id);
           $deck->decrement('card_count');
        });

        return redirect()->route('decks.show', $deck_id)
            ->with('success', 'Thẻ đã được xóa thành công!');
    }
}
