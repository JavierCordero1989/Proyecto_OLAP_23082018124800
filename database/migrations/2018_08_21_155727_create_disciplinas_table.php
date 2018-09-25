<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_disciplinas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo', 191);
            $table->string('descriptivo', 191);
            $table->unsignedInteger('id_area');
            $table->foreign('id_area')->references('id')->on('tbl_areas');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_disciplinas');
    }
}
