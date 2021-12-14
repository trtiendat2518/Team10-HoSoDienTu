<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcedureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_procedure', function (Blueprint $table) {
            $table->increments('procedure_id');
            $table->string('procedure_code', 10);
            $table->string('procedure_title', 200);
            $table->string('procedure_content');
            $table->int('procedure_time');
            $table->int('procedure_method');
            $table->int('procedure_fee');
            $table->int('procedure_category');
            $table->int('procedure_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_procedure');
    }
}
