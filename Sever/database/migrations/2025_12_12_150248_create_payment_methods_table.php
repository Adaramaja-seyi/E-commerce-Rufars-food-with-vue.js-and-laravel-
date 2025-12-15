<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // Visa, Mastercard, etc.
            $table->string('last4', 4); // Last 4 digits
            $table->string('expiry', 5)->nullable(); // MM/YY
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            
            // Index for faster queries
            $table->index('user_id');
            $table->index('is_default');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
