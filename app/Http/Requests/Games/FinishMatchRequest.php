<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class FinishMatchRequest extends FormRequest
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
            'man_of_the_match' => 'required|exists:users,id',
            'google_drive_link' => 'required|url',
        ];
    }
}
