<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademyCourseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academy_course_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_type_id');
            $table->unsignedBigInteger('academy_id');
            $table->timestamps();

            $table->foreign('course_type_id')
                ->references('id')
                ->on('course_types');
            $table->foreign('academy_id')
                ->references('id')
                ->on('academies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academy_course_types');
    }
}
