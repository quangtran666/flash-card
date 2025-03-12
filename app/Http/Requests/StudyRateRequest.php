<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'card_id' => 'required|exists:cards,id',
            'rating' => 'required|integer|between:1,3', // 1=hard, 2=medium, 3=easy
            'study_session_id' => 'required|exists:study_sessions,id'
        ];
    }

    public function messages() : array
    {
        return [
            'card_id.required' => 'Card ID is required',
            'card_id.exists' => 'Card does not exist',
            'rating.required' => 'Rating is required',
            'rating.between' => 'Rating must be between 1 and 3',
            'study_session_id.required' => 'Study session ID is required',
            'study_session_id.exists' => 'Study session does not exist',
        ];
    }
}
