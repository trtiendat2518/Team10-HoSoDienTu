<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_form_teacher', function (Blueprint $table) {
            $table->increments('form_teacher_id');
            $table->integer('form_teacher_lecturer');
            $table->integer('form_teacher_class');
            $table->integer('form_teacher_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_form_teacher');
    }
}
