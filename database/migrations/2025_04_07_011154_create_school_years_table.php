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
        // SCHOOL YEARS (with status management)
        Schema::create('school_years', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('e.g. 2023-2024');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['planning', 'active', 'archived'])->default('planning');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('school_years');
        Schema::enableForeignKeyConstraints();
       
    }
};
