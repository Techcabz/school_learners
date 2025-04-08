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
        // ENROLLMENT ELIGIBILITY (with more credential options)
        Schema::create('enrollment_eligibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();

            // Credential presented for Grade 1
            $table->enum('eligibility_type', [
                'kinder_progress_report',
                'ecco_checklist',
                'kindergarten_certificate',
                'pbt_passer',
                'als_a_e',
                'others'
            ])->default('kinder_progress_report');

            $table->string('pbt_rating')->nullable();
            $table->date('pbt_exam_date')->nullable();
            $table->string('pbt_testing_center')->nullable();
            $table->string('other_credential_specify')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_eligibilities');
    }
};
