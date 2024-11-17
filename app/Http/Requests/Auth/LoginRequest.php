<?php

namespace App\Http\Requests\Auth;

use App\Rules\CheckUserBlock;
use App\Rules\UserSocialite;
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
            'email' => ['sometimes', 'email:filter', new UserSocialite($this->social_id)],
            'social_id' => ['required', new CheckUserBlock()],
        ];
    }
}