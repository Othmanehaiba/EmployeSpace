<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('candidate_cv_skill', function (Blueprint $table) {
            $table->id();

            $table->foreignId('candidate_cv_id')->constrained('candidate_cvs')->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained('skills')->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['candidate_cv_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_cv_skill');
    }
};
