<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_cv_id')->constrained('candidate_cvs')->cascadeOnDelete();

            $table->string('degree');
            $table->string('school');
            $table->integer('start_year')->nullable();
            $table->integer('end_year')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
