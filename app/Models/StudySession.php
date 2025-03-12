<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'deck_id',
        'start_time',
        'end_time',
        'cards_studied',
        'easy_count',
        'medium_count',
        'hard_count'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    public function deck() : BelongsTo
    {
        return $this->belongsTo(Deck::class);
    }

    public function cardProgress() : HasMany
    {
        return $this->hasMany(CardProgress::class);
    }


}
