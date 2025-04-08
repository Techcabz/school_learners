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
        // STUDENT ENROLLMENTS (with enhanced status tracking)
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_class_id')->constrained()->cascadeOnDelete();
            $table->date('enrollment_date');
            $table->enum('status', [
                'pending',
                'active',
                'transferred',
                'dropped',
                'graduated',
                'incomplete'
            ])->default('pending');
            $table->date('status_date')->nullable();
            $table->text('status_notes')->nullable();
            $table->timestamps();

            $table->unique(['learner_id', 'school_class_id']);
            $table->index(['school_class_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
