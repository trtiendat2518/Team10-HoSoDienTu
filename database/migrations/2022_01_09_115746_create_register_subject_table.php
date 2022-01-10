<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_register_subject', function (Blueprint $table) {
            $table->increments('register_subject_id');
            $table->integer('register_subject_student');
            $table->integer('register_subject_program');
            $table->integer('register_subject_exercise');
            $table->integer('register_subject_exam');
            $table->integer('register_subject_final');
            $table->integer('register_subject_yearstart');
            $table->integer('register_subject_yearend');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_register_subject');
    }
}
