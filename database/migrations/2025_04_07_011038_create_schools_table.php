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
        // SCHOOL INFORMATION (with contact details)
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('school_id')->unique();
            $table->string('name');
            $table->text('address');
            $table->string('district');
            $table->string('division');
            $table->string('region');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('schools');
        Schema::enableForeignKeyConstraints();
       
    }
};
