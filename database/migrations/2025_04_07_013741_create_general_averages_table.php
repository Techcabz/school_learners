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
       
       
     
        // GENERAL AVERAGES (with historical tracking)
        Schema::create('general_averages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('period_id')->nullable()->constrained('academic_periods')->cascadeOnDelete();
            $table->decimal('average', 5, 2);
            $table->integer('subjects_count');
            $table->decimal('highest_possible', 5, 2)->default(100.00);
            $table->decimal('lowest_possible', 5, 2)->default(0.00);
            $table->integer('rank')->nullable();
            $table->timestamps();
            
            $table->unique(['enrollment_id', 'period_id']);
        });

    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_averages');
    }
};
