<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_request', function (Blueprint $table) {
            $table->increments('request_id');
            $table->integer('request_student');
            $table->string('request_title', 200);
            $table->longText('request_content');
            $table->integer('request_status');
            $table->longText('request_reply');
            $table->string('request_file', 255);
            $table->timestamp('created_at', 50);
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_request');
    }
}
