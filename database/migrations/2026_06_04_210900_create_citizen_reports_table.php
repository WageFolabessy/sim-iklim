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
        Schema::create('citizen_reports', function (Blueprint $table) {
            $table->id();
            $table->string('reporter_name')->nullable();
            $table->string('location');
            $table->string('anomaly_type');
            $table->text('description');
            $table->string('status')->default('pending')->index();
            $table->timestamps();

            // Index on created_at for chronological queries
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizen_reports');
    }
};
