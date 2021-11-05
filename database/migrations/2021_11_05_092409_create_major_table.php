<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMajorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_major', function (Blueprint $table) {
            $table->increments('major_id');
            $table->string('major_code', 10);
            $table->string('major_name', 50);
            $table->string('major_faculty', 3);
            $table->integer('major_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_major');
    }
}
