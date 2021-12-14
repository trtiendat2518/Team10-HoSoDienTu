<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_student_info', function (Blueprint $table) {
            $table->increments('student_info_id');
            $table->integer('student_id_ref');
            $table->integer('student_course');
            $table->integer('student_faculty');
            $table->integer('student_major');
            $table->string('student_avatar',255);
            $table->timestamp('student_birthday');
            $table->integer('student_gender');
            $table->string('student_ethnic',255);
            $table->string('student_religion',255);
            $table->string('student_phone',10);
            $table->string('student_deskphone',10);
            $table->string('student_address',100);
            $table->string('student_country',255);
            $table->string('student_identify_card',12);
            $table->string('student_birth_place',50);
            $table->string('student_other_email',100);
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
        Schema::dropIfExists('tbl_student_info');
    }
}
