<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('loan_duration_days')->default(14);
            $table->unsignedInteger('max_active_loans')->default(3);
            $table->decimal('fine_per_day', 8, 2)->default(1.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
