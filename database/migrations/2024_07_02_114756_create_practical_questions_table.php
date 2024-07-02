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
        Schema::create('practical_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('practical_tests_id');
            $table->text('question');
            $table->timestamps();

            $table->foreign('practical_tests_id')->references('id')->on('practical_tests')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('practical_questions');
    }
};
