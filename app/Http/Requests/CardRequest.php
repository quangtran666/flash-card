<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'deck_id' => 'required|exists:decks,id',
            'front_content' => 'required|string|max:255',
            'back_content' => 'required|string|max:255',
            'pronunciation' => 'nullable|string|max:100',
            'example' => 'nullable|string',
            'image_url' => 'nullable|url',
        ];
    }

    public function messages() : array
    {
        return [
            'deck_id.required' => 'The deck_id field is required.',
            'deck_id.exists' => 'The selected deck_id is invalid.',
            'front_content.required' => 'The front_content field is required.',
            'back_content.required' => 'The back_content field is required.',
            'image_url.url' => 'The image_url field must be a valid URL.',
        ];
    }
}
