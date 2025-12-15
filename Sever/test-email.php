<?php

/**
 * Quick Email Test Script
 * 
 * Run this to test if your email configuration is working:
 * php test-email.php your-email@gmail.com
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get email from command line argument
$toEmail = $argv[1] ?? null;

if (!$toEmail) {
    echo "❌ Usage: php test-email.php your-email@gmail.com\n";
    exit(1);
}

echo "📧 Testing email configuration...\n";
echo "To: {$toEmail}\n";
echo "From: " . config('mail.from.address') . "\n";
echo "SMTP Host: " . config('mail.mailers.smtp.host') . "\n";
echo "SMTP Port: " . config('mail.mailers.smtp.port') . "\n\n";

try {
    \Illuminate\Support\Facades\Mail::raw('This is a test email from Rufars Food. If you received this, your email configuration is working correctly! 🎉', function($message) use ($toEmail) {
        $message->to($toEmail)
                ->subject('Test Email - Rufars Food');
    });
    
    echo "✅ Email sent successfully!\n";
    echo "📬 Check your inbox (and spam folder) at: {$toEmail}\n";
    echo "\nIf you don't receive it within 1 minute, check:\n";
    echo "1. Your .env MAIL_* settings\n";
    echo "2. storage/logs/laravel.log for errors\n";
    echo "3. Your spam folder\n";
    
} catch (\Exception $e) {
    echo "❌ Failed to send email!\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    echo "Common fixes:\n";
    echo "1. Check MAIL_USERNAME and MAIL_PASSWORD in .env\n";
    echo "2. For Gmail, use App Password (not regular password)\n";
    echo "3. Run: php artisan config:clear\n";
    echo "4. Check storage/logs/laravel.log for details\n";
}
