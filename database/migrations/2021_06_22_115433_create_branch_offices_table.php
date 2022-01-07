<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_offices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academy_id');
            $table->string('branch_name',100);
            $table->string('street',100);
            $table->string('streetHeight',20);
            $table->string('noc');
            $table->boolean('isActive');
            $table->timestamps();

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
        Schema::dropIfExists('branch_offices');
    }
}
