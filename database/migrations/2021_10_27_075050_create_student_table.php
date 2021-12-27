<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_student', function (Blueprint $table) {
            $table->increments('student_id');
            $table->string('student_code',50);
            $table->string('student_fullname',50);
            $table->string('student_email',100);
            $table->integer('student_course')->default(null);
            $table->integer('student_faculty')->default(null);
            $table->integer('student_major')->default(null);
            $table->integer('student_class')->default(null);
            $table->string('student_avatar',255)->default(null);
            $table->timestamp('student_birthday')->default(null);
            $table->integer('student_gender')->default(null);
            $table->string('student_ethnic',255)->default(null);
            $table->string('student_religion',255)->default(null);
            $table->string('student_phone',10)->default(null);
            $table->string('student_address',100)->default(null);
            $table->string('student_country',255)->default(null);
            $table->string('student_identify_card',12)->default(null);
            $table->string('student_birth_place',50)->default(null);
            $table->string('student_other_email',100)->default(null);
            $table->integer('student_role')->default(0);
            $table->integer('student_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_student');
    }
}
