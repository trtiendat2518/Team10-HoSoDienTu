<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_subject', function (Blueprint $table) {
            $table->increments('subject_id');
            $table->string('subject_code', 10);
            $table->string('subject_name', 100);
            $table->integer('subject_credit');
            $table->string('subject_faculty',10);
            $table->integer('subject_practice_period');
            $table->integer('subject_theory_period');
            $table->integer('subject_score_exercise');
            $table->integer('subject_score_exam');
            $table->integer('subject_score_final');
            $table->integer('subject_type')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_subject');
    }
}
