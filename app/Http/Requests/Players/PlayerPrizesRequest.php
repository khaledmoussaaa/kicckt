<?php

namespace App\Http\Requests\Players;

use Illuminate\Foundation\Http\FormRequest;

class PlayerPrizesRequest extends FormRequest
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
            'id' => 'nullable|integer',
            'media' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,avi,mov,wmv,webm',
            'user_id' => 'required|integer|exists:users,id'
        ];
    }
}
