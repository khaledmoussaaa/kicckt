<?php

namespace App\Http\Requests\GameMatches;

use Illuminate\Foundation\Http\FormRequest;

class EndMatchRequest extends FormRequest
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
            'red_goals' => 'required|integer',
            'purple_goals' => 'required|integer',
            'man_of_the_match' => 'nullable|exists:users,id',
            'google_drive_link' => 'nullable|url',
            'joins' => 'required|array',
            'joins.*.id' => 'required|integer|exists:joins,id',
            'joins.*.goals' => 'nullable|integer',
            'joins.*.assists' => 'nullable|integer',
            'joins.*.goal_keeper' => 'nullable|integer',
            'joins.*.user_id' => 'required|integer|exists:users,id',
            'joins.*.match_id' => 'required|integer|exists:match_games,id',
        ];
    }
}
