<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeckRequest;
use App\Models\Deck;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DeckController extends Controller
{
    /**
     * Display a listing of the decks.
     *
     * This method retrieves all decks and displays them in a list view.
     *
     * @return View
     */
    public function index() : View
    {
        $decks = Deck::withCount('cards')->latest()->get();
        return view('decks.index', compact('decks'));
    }

    /**
     * Show the form for creating a new deck.
     *
     * This method displays the form to create a new deck.
     *
     * @return View
     */
    public function create() : View
    {
        return view('decks.create');
    }

    /**
     * Store a newly created deck in storage.
     *
     * This method validates and stores the new deck data.
     * Using DeckRequest for validation enforces separation of concerns.
     *
     * @param  DeckRequest  $request  The validated request data
     * @return RedirectResponse
     */
    public function store(DeckRequest $request) : RedirectResponse
    {
        DB::transaction(static function () use ($request) {
           Deck::create($request->validated());
        });

        return redirect()->route('decks.index')
            ->with('success', 'Deck created successfully.');
    }

    /**
     * Display the specified deck.
     *
     * This method shows details of a specific deck including its cards.
     * Using route model binding for automatic resolution of Deck model.
     *
     * @param  Deck  $deck  The deck to display
     * @return View
     */
    public function show(Deck $deck) : View
    {
        // Eager load the cards relationship to avoid N+1 query problem
        $deck->load('cards');

        return view('decks.show', compact('deck'));
    }

    /**
     * Show the form for editing the specified deck.
     *
     * This method displays the form to edit an existing deck.
     *
     * @param  Deck  $deck  The deck to edit
     * @return View
     */
    public function edit(Deck $deck) : View
    {
        return view('decks.edit', compact('deck'));
    }

    /**
     * Update the specified deck in storage.
     *
     * This method validates and updates the deck data.
     *
     * @param  DeckRequest  $request  The validated request data
     * @param  Deck  $deck  The deck to update
     * @return RedirectResponse
     */
    public function update(DeckRequest $request, Deck $deck) : RedirectResponse
    {
        DB::transaction(static function () use ($request, $deck) {
            $deck->update($request->validated());
        });

        return redirect()->route('decks.index')
            ->with('success', 'Deck updated successfully.');
    }

    /**
     * Remove the specified deck from storage.
     *
     * This method deletes a deck and its related cards.
     * The database cascade delete will handle deleting related cards.
     *
     * @param  Deck  $deck  The deck to delete
     * @return RedirectResponse
     */
    public function destroy(Deck $deck) : RedirectResponse
    {
        DB::transaction(static function () use ($deck) {
            $deck->delete();
        });

        return redirect()->route('decks.index')
            ->with('success', 'Deck deleted successfully.');
    }
}
