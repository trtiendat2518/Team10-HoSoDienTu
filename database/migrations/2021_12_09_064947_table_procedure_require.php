<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableProcedureRequire extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_procedure_require', function (Blueprint $table) {
            $table->increments('procedure_require_id');
            $table->string('procedure_require_code', 10);
            $table->integer('procedure_require_detail');
            $table->dateTime('procedure_require_datesend');
            $table->dateTime('procedure_require_dateget');
            $table->int('procedure_require_status');
            $table->string('procedure_require_student', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_procedure_require');
    }
}
