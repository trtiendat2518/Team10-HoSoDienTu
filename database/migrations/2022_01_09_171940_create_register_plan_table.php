<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_register_plan', function (Blueprint $table) {
            $table->increments('register_plan_id');
            $table->integer('register_plan_student');
            $table->integer('register_plan_program');
            $table->integer('register_plan_yearstart');
            $table->integer('register_plan_yearend');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_register_plan');
    }
}
