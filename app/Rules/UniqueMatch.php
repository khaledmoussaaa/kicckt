<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueMatch implements ValidationRule
{
    protected $staduim_id;
    protected $date;
    protected $time_from;
    protected $time_to;

    /**
     * Create a new rule instance.
     */
    public function __construct($staduim_id, $date, $time_from, $time_to)
    {
        $this->staduim_id = $staduim_id;
        $this->date = $date;
        $this->time_from = $time_from;
        $this->time_to = $time_to;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if a match already exists with the same stadium, date, time_from, and time_to
        $exists = DB::table('match_games')->where([['staduim_id', $this->staduim_id], ['date', $this->date], ['time_from', $this->time_from], ['time_to', $this->time_to]])->exists();

        // If a match exists, fail the validation
        if ($exists) {
            $fail('A match already exists at this stadium during the specified time and date.');
        }
    }
}