<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\GameFowl;

$counts = [
    'total' => GameFowl::count(),
    'male' => GameFowl::where('sex', 'Male')->count(),
    'fighter' => GameFowl::where('classification', 'Fighter')->count(),
    'male_fighter' => GameFowl::where('sex', 'Male')->where('classification', 'Fighter')->count(),
    'healthy_male_fighter' => GameFowl::where('sex', 'Male')->where('classification', 'Fighter')->where('initial_health_status', 'Healthy')->count(),
    'fit_to_fight' => GameFowl::fitToFight()->where('sex', 'Male')->where('initial_health_status', 'Healthy')->count(),
];

echo json_encode($counts, JSON_PRETTY_PRINT);
