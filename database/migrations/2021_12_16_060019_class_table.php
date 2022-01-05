<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_class', function (Blueprint $table) {
            $table->increments('class_id');
            $table->string('class_name', 50);
            $table->integer('class_form_teacher');
            $table->integer('class_course');
            $table->integer('class_faculty');
            $table->integer('class_major');
            $table->integer('class_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_class');
    }
}
