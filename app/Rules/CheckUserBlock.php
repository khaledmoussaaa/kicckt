<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class CheckUserBlock implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Query to check if the user is blocked
        $user = DB::table('users')->where('email', $value)->first();

        if ($user && $user->deleted_at) {
            // If the user is blocked, return an error message
            $fail('Your account has been restricted due to guideline violations. Please contact support if you believe this is a mistake.');
        }
    }
}
