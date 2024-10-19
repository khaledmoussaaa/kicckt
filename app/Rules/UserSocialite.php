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
        $user = User::where('social_id', $this->social_id)->exists();
        if ($user) {
            $user = User::where('email', $value)->where('social_id', $this->social_id)->exists();
            if (!$user) {
                $fail('Error occured during authinitcated');
            }
        }
    }
}
