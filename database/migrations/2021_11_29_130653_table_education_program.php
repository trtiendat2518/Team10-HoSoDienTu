<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableEducationProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_education_program', function (Blueprint $table) {
            $table->increments('education_program_id');
            $table->string('education_program_code', 10);
            $table->integer('education_program_course');
            $table->integer('education_program_major');
            $table->string('education_program_faculty',10);
            $table->integer('education_program_year');
            $table->integer('education_program_credit')->default(0);
            $table->integer('education_program_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_education_program');
    }
}
