<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassDayStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_day_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_day_id');
            $table->unsignedBigInteger('student_id');
            $table->boolean('attendance');
            $table->timestamps();

            $table->foreign('class_day_id')
                ->references('id')
                ->on('class_days');
            $table->foreign('student_id')
                ->references('id')
                ->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_day_students');
    }
}
