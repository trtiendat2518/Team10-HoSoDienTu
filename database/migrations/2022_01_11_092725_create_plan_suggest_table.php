<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanSuggestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_plan_suggest', function (Blueprint $table) {
            $table->increments('plan_suggest_id');
            $table->integer('plan_suggest_student');
            $table->integer('plan_suggest_class');
            $table->integer('plan_suggest_status');
            $table->integer('plan_suggest_lecturer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_plan_suggest');
    }
}
