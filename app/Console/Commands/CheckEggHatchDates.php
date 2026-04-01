<?php

namespace App\Console\Commands;

use App\Models\EggCollection;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckEggHatchDates extends Command
{
    protected $signature = 'eggs:check-hatch-dates';

    protected $description = 'Auto-complete egg collections whose expected hatch date has been reached, marking all eggs as hatched.';

    public function handle(): int
    {
        $today = Carbon::today();

        $due = EggCollection::whereIn('incubation_status', ['Pending', 'Incubating'])
            ->whereNotNull('expected_hatch_date')
            ->whereDate('expected_hatch_date', '<=', $today)
            ->get();

        if ($due->isEmpty()) {
            $this->info('No egg collections are due for hatching today.');
            return Command::SUCCESS;
        }

        $count = 0;
        foreach ($due as $collection) {
            // Fall back to egg_count if incubated_count was never set
            $incubated = (int) ($collection->incubated_count ?? 0) > 0
                ? (int) $collection->incubated_count
                : (int) ($collection->egg_count ?? 0);

            $collection->update([
                'incubation_status' => 'Completed',
                'incubated_count'   => $incubated,
                'hatched_count'     => $incubated, // mark ALL as hatched
                'failed_count'      => 0,
            ]);

            $this->line("  → Collection #{$collection->id}: {$incubated} egg(s) marked as hatched.");
            $count++;
        }

        $this->info("Done. {$count} collection(s) completed.");

        return Command::SUCCESS;
    }
}
