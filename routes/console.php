<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Check egg hatch dates every day at midnight and update status to Completed
// when the expected hatch date has been reached.
Schedule::command('eggs:check-hatch-dates')->dailyAt('00:01');
