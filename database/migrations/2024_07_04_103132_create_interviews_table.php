<?php

// database/migrations/xxxx_xx_xx_create_interviews_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration
{
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->date('interview_date');
            $table->time('interview_time');
            $table->unsignedBigInteger('job_listings_id');
            $table->unsignedBigInteger('location_id');
            $table->string('title');
            $table->text('requirements');
            $table->timestamps();

            // Add foreign key constraints if needed
            $table->foreign('job_listings_id')->references('id')->on('job_listings')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('interviews');
    }
}
