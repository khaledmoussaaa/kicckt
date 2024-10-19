<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class EndFinishMatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'purple_goals' => 'required|integer',
            'red_goals' => 'required|integer',
            'man_of_the_match' => 'nullable|exists:users,id',
            'google_drive_link' => 'nullable|url',
            'match_id' => 'required|integer|exists:match_games,id',
        ];
    }
}
