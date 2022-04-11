<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table)
        {
            $table->id();
            $table->string('name',100);
            $table-> string('last_name',100);   
            $table->string('dni',30)->unique();
            $table->date('birth_date')->nullable();
            $table->string('phone',30)->nullable();
            $table->string('email')->unique()->nullable();
            $table->boolean('isActive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
