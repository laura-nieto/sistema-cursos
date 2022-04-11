<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->timestampRange('hour_range');
            $table->string('name_instructor',120)->nullable();
            $table->timestamps();

            $table->foreign('course_id')
                ->references('id')
                ->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_days');
    }
}
