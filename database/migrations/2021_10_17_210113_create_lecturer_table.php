<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_lecturer', function (Blueprint $table) {
            $table->increments('lecturer_id');
            $table->string('lecturer_fullname',255);
            $table->string('lecturer_email',100);
            $table->string('lecturer_code',50);
            $table->integer('lecturer_faculty')->default(null);
            $table->integer('lecturer_role')->default(0);
            $table->integer('lecturer_level')->default(0);
            $table->integer('lecturer_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_lecturer');
    }
}
