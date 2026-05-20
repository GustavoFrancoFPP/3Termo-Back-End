<?php
// Script temporário para rodar seeder
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Rodar seeder
$seeder = new \Database\Seeders\SenaiDataSeeder();
$seeder->run();

echo "✅ Seeder SenaiDataSeeder executado com sucesso!\n";
