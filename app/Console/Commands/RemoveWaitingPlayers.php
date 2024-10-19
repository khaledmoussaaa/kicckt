<?php

namespace App\Console\Commands;

use App\Models\MatchGame;
use Illuminate\Console\Command;

class RemoveWaitingPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:remove-waiting-players';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove waiting players from matches that have started.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = now();
        $matches = MatchGame::where('time_from', '<=', $currentTime)->get();

        foreach ($matches as $match) {
            $match->joins()->where('status', 'waiting')->delete();
        }

        $this->info('Removed waiting players for matches that have started.');
    }
}
