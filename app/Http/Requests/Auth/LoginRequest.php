<?php

namespace App\Http\Requests\Auth;

use App\Rules\CheckUserBlock;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            // Login Validations
            'email' => ['sometimes', 'email:filter', 'exists:users,email', new CheckUserBlock()],
            'social_id' => ['sometimes', 'exists:users,social_id', new CheckUserBlock()],
            'password' => 'required|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'The email or password not correct',
            'social_id.exists' => 'The email or password not correct',
        ];
    }
}
