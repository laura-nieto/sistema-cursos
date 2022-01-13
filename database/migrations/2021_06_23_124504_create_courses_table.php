<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_office_id');
            $table->unsignedBigInteger('type_course_id');
            $table->time('total_hours');
            $table->integer('student_capacity');
            $table->enum('modality',['Virtual','Presencial']);
            $table->date('expiration');
            $table->boolean('isActive');
            $table->boolean('certificated')->default(0);
            $table->timestamps();

            $table->foreign('branch_office_id')
                ->references('id')
                ->on('branch_offices')
                ->onDelete('cascade');
            $table->foreign('type_course_id')
                ->references('id')
                ->on('course_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
