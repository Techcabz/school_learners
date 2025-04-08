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
        // LEARNER INFORMATION (with soft deletes)
        Schema::create('learners', function (Blueprint $table) {
            $table->id();
            $table->string('lrn')->unique()->comment('Learner Reference Number');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('name_extension')->nullable();
            $table->date('birthdate');
            $table->enum('sex', ['Male', 'Female']);
            $table->timestamps();
            $table->softDeletes(); // Added for safe deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learners');
    }
};
