<?php

namespace App\Http\Requests\Joins;

use App\Rules\UserNotInAnotherGame;
use Illuminate\Foundation\Http\FormRequest;

class JoinRequest extends FormRequest
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
            // Validations for joining in new match
            'team_color' => 'required|in:red,purple',
            'position' => 'required|integer',
            'match_id' => 'required|integer|exists:match_games,id',
        ];
    }
}
