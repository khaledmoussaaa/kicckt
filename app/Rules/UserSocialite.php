<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserSocialite implements ValidationRule
{
    protected $social_id;

    /**
     * Create a new rule instance.
     */
    public function __construct($social_id)
    {
        $this->social_id = $social_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::withTrashed()->where(['social_id' => $this->social_id, 'email' => $value])->first();
        if ($user && $user->deleted_at) {
            $fail('Your account has been restricted due to guideline violations. Please contact support if you believe this is a mistake.');
        }
    }
}
