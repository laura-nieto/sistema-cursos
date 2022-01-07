<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academies', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('street',100);
            $table->string('streetHeight',20);
            $table->string('responsible',100);
            $table->string('phone',30);
            $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('noc');
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
        Schema::dropIfExists('academies');
    }
}
