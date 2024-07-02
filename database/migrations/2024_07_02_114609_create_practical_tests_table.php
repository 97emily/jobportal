<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('practical_tests', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->text('instructions');
        $table->dateTime('deadline');
        $table->unsignedBigInteger('category_id');
        $table->timestamps();

        $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('practical_tests');
}

};
