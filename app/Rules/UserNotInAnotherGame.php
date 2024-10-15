<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use App\Models\Join;
use App\Models\MatchGame;

class UserNotInAnotherGame implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $newMatch = MatchGame::find($value);

        if ($newMatch) {
            $last_gamejoined = Join::where('user_id', auth()->id())
                ->whereHas('match', function ($query) use ($newMatch) {
                    $query->where('date', $newMatch->date)
                        ->where('time_from', '<=', $newMatch->time_to)
                        ->where('time_to', '>=', $newMatch->time_from);
                })->exists();

            if ($last_gamejoined) {
                $fail('You are already in another match during the same time.');
            }
        }
    }
}
