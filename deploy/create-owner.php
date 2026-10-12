<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
// Run only for a completely empty users table; never overwrite an existing account.
if (App\Models\User::exists()) { exit(0); }
$email = getenv('INITIAL_OWNER_EMAIL');
$password = getenv('INITIAL_OWNER_PASSWORD');
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password ?: '') < 12) {
    fwrite(STDERR, "Set a valid INITIAL_OWNER_EMAIL and INITIAL_OWNER_PASSWORD of at least 12 characters.\n");
    exit(1);
}
App\Models\User::create([
    'name' => getenv('INITIAL_OWNER_NAME') ?: 'Owner',
    'email' => $email,
    'password' => Illuminate\Support\Facades\Hash::make($password),
    'role' => 'owner',
    'is_active' => true,
]);
echo "Initial owner account created.\n";
