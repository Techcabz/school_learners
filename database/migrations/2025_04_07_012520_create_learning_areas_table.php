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
        // LEARNING AREAS (with subject categories)
        Schema::create('learning_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->enum('category', ['core', 'specialized', 'applied', 'enhancement']);
            $table->integer('display_order')->default(0);
            $table->boolean('has_quarterly_grades')->default(true);
            $table->timestamps();

            $table->unique(['name', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_areas');
    }
};
