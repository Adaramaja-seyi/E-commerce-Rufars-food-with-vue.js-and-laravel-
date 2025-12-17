<?php

// Quick test script to check payment methods data
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PaymentMethod;
use App\Models\User;

echo "=== Payment Methods Test ===\n\n";

// Get all payment methods
$paymentMethods = PaymentMethod::all();

echo "Total payment methods: " . $paymentMethods->count() . "\n\n";

if ($paymentMethods->count() > 0) {
    foreach ($paymentMethods as $method) {
        echo "ID: {$method->id}\n";
        echo "User ID: {$method->user_id}\n";
        echo "Type: {$method->type}\n";
        echo "Last4: {$method->last4}\n";
        echo "Expiry: {$method->expiry}\n";
        echo "Is Default: " . ($method->is_default ? 'Yes' : 'No') . "\n";
        echo "---\n";
    }
} else {
    echo "No payment methods found in database.\n";
    echo "Try adding one through the UI first.\n";
}

echo "\n=== Testing JSON Response ===\n";
$testMethod = $paymentMethods->first();
if ($testMethod) {
    echo json_encode($testMethod, JSON_PRETTY_PRINT);
}
