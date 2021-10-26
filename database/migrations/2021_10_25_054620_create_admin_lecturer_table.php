<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLecturerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_lecturer_info', function (Blueprint $table) {
            $table->increments('lecturer_info_id');
            $table->string('lecturer_code',50);
            $table->integer('lecturer_faculty');
            $table->string('lecturer_avatar',255);
            $table->timestamp('lecturer_birthday');
            $table->integer('lecturer_gender');
            $table->string('lecturer_ethnic',255);
            $table->string('lecturer_religion',255);
            $table->string('lecturer_phone',10);
            $table->string('lecturer_deskphone',10);
            $table->string('lecturer_address',100);
            $table->string('lecturer_country',255);
            $table->string('lecturer_identify_card',12);
            $table->string('lecturer_birth_place',50);
            $table->string('lecturer_other_email',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_lecturer_info');
    }
}
