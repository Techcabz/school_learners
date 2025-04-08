<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('quarterly_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('learning_area_id')->constrained();
            $table->foreignId('period_id')->constrained('academic_periods');
            
            // Grading components
            $table->decimal('written_work', 5, 2)->nullable();
            $table->decimal('performance_task', 5, 2)->nullable();
            $table->decimal('quarterly_assessment', 5, 2)->nullable();
            $table->decimal('rating', 5, 2)->nullable();
            
            // Make graded_by nullable and properly constrained
            $table->foreignId('graded_by')
                  ->nullable()
                  ->constrained('teachers')
                  ->nullOnDelete();
                  
            $table->timestamp('graded_at')->nullable();
            $table->enum('status', ['draft', 'submitted', 'approved'])->default('draft');
            $table->string('remarks')->nullable();
            $table->timestamps();
    
            $table->unique(['enrollment_id', 'learning_area_id', 'period_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quarterly_grades');
    }
};
