<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansuggestDetailTabl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_plansuggest_detail', function (Blueprint $table) {
            $table->increments('plansuggest_detail_id');
            $table->integer('plansuggest_program');
            $table->integer('plansuggest_detail_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_plansuggest_detail');
    }
}
