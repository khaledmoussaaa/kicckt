<?php

namespace App\Http\Requests\Games;

use App\Rules\UniqueMatch;
use Illuminate\Foundation\Http\FormRequest;

class MatchRequest extends FormRequest
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
            'staduim_id' => 'required|exists:staduims,id',
            'match_name' => ['required', 'string', 'max:100', new UniqueMatch($this->staduim_id, $this->date, $this->time_from, $this->time_to)],
            'date' => 'required|date',
            'time_from' => 'required|date_format:H:i:s',
            'time_to' => 'required|date_format:H:i:s|after:time_from',
        ];
    }
}
