<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('recruteur_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('company_name')->nullable();

            $table->string('contract_type'); // CDI, CDD, Stage...
            $table->string('title');
            $table->string('location')->nullable();
            $table->date('start_date')->nullable();

            $table->text('description');
            $table->string('image_path'); // obligatoire

            $table->string('status')->default('open'); // open|closed
            $table->timestamp('closed_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'contract_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
