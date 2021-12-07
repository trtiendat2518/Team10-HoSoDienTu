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
            $table->string('program_detail_subject', 10);
            $table->integer('program_detail_semester');
            $table->string('program_detail_major', 10);
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
