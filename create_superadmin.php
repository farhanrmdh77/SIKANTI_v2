<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = new App\User();
$user->name = 'Superadmin';
$user->email = 'superadmin@bpk.go.id';
$user->password = bcrypt('password');
$user->role = 'Superadmin';
$user->save();
echo "Superadmin created.\n";
