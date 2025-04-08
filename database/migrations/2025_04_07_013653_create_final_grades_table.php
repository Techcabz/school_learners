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
          // FINAL GRADES (with completion tracking)
          Schema::create('final_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('learning_area_id')->constrained()->cascadeOnDelete();
            $table->decimal('rating', 5, 2)->nullable();
            $table->string('remarks')->nullable();
            $table->integer('quarters_count')->default(0);
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_credited')->default(false);
            $table->timestamps();
            
            $table->unique(['enrollment_id', 'learning_area_id']);
            $table->index(['enrollment_id', 'is_completed']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_grades');
    }
};
