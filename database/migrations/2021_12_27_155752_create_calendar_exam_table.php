<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_calendar_exam', function (Blueprint $table) {
            $table->increments('calendar_exam_id');
            $table->integer('calendar_exam_schedule');
            $table->integer('calendar_exam_faculty');
            $table->integer('calendar_exam_major');
            $table->integer('calendar_exam_course');
            $table->integer('calendar_exam_subject');
            $table->string('calendar_exam_room', 20);
            $table->string('calendar_exam_method', 50);
            $table->integer('calendar_exam_semester');
            $table->string('calendar_exam_place', 100);
            $table->string('calendar_exam_note')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_calendar_exam');
    }
}
