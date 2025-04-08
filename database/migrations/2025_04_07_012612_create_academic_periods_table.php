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
       
        // ACADEMIC PERIODS (with grading period types)
        Schema::create('academic_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_year_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['quarter', 'semester', 'final', 'special'])->default('quarter');
            $table->integer('order')->comment('1-4 for quarters');
            $table->string('code')->comment('Q1, Q2, etc.');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('grading_start_date')->nullable();
            $table->date('grading_end_date')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->timestamps();
            
            $table->unique(['school_year_id', 'order']);
            $table->index(['school_year_id', 'is_active']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_periods');
    }
};
