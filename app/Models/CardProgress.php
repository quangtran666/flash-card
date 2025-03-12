<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_id',
        'study_session_id',
        'familiarity_level',
        'next_review_date',
        'review_count'
    ];

    protected $casts = [
        'next_review_date' => 'date'
    ];

    public function studySession() : BelongsTo
    {
        return $this->belongsTo(StudySession::class);
    }

    public function card() : BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
