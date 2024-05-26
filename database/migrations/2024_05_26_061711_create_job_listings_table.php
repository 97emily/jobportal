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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('job_description');
            $table->enum('status', ['open', 'preview', 'closed']);
            $table->date('closing_date');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('location')->nullable();
            $table->decimal('salary_min', 8, 2)->nullable();
            $table->decimal('salary_max', 8, 2)->nullable();
            $table->enum('employment_type', ['full-time', 'part-time', 'contract', 'temporary', 'internship'])->nullable();
            $table->enum('experience_level', ['entry', 'mid', 'senior', 'executive'])->nullable();
            $table->string('education_requirements')->nullable();
            $table->string('assessment_test')->nullable(); // Details about the assessment test
            $table->integer('threshold_score')->nullable(); // Minimum score required to pass the assessment
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
