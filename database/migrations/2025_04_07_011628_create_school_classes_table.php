<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('school_classes')) {
            Schema::create('school_classes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('school_id')->constrained()->cascadeOnDelete();
                $table->foreignId('school_year_id')->constrained()->cascadeOnDelete();
                $table->string('grade_level');
                $table->string('section');
                $table->foreignId('adviser_id')->nullable()->constrained('teachers')->nullOnDelete();
                $table->integer('max_capacity')->default(40);
                $table->integer('current_enrollment')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                // Shorter constraint name
                $table->unique(
                    ['school_id', 'school_year_id', 'grade_level', 'section'],
                    'school_classes_unique_combo'
                );
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};