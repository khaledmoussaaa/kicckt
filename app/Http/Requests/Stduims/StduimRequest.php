<?php

namespace App\Http\Requests\Stduims;

use Illuminate\Foundation\Http\FormRequest;

class StduimRequest extends FormRequest
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
            // Validations for creating new stduim
            'media' => 'nullable|image',
            'staduim_name' => 'required|string|max:100',
            'area' => 'required|string',
            'location' => 'required|url',
            'players_number' => 'required|integer',
            'old_price' => 'nullable|numeric',
            'price' => 'required|numeric',
        ];
    }
}
