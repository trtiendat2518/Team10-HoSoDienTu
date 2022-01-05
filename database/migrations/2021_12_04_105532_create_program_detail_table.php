<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_program_detail', function (Blueprint $table) {
            $table->increments('program_detail_id');
            $table->string('program_detail_code', 10);
            $table->integer('program_detail_subject');
            $table->integer('program_detail_semester');
            $table->string('program_detail_note', 10);
            $table->string('program_detail_calendar', 255);
            $table->string('program_detail_lecturer', 100);
            $table->date('program_detail_start');
            $table->date('program_detail_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_program_detail');
    }
}
