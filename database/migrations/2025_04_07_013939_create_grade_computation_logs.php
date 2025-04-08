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
        Schema::create('grade_computation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('period_id')->nullable()->constrained('academic_periods');
            $table->string('computation_type'); // quarterly, final, average
            $table->json('parameters')->nullable();
            $table->json('results')->nullable();
            $table->foreignId('computed_by')->constrained('teachers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_computation_logs');
    }
};
