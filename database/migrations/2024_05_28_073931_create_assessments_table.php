
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('job_listings_id');
            $table->timestamps();

            $table->foreign('job_listings_id')->references('id')->on('job_listings')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessments');
    }
}
