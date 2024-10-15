<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            // Register Validations
            'media' => 'nullable|image',
            'name' => 'required|string|min:3|max:30',
            'phone' => 'required|min:9|max:14|unique:users,phone',
            'email' => 'sometimes|email:filter|unique:users,email',
            'social_id' => 'sometimes|string|unique:users,social_id',
            'password' => 'required|min:8|confirmed',
        ];
    }
}
