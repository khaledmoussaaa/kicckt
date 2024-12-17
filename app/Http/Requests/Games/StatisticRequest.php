<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class StatisticRequest extends FormRequest
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
            'goals' => 'sometimes|integer',
            'assists' => 'sometimes|integer',
            'goal_keeper' => 'sometimes|integer',
            'statistic_id' => 'required|integer|exists:statistics,id'
        ];
    }
}
