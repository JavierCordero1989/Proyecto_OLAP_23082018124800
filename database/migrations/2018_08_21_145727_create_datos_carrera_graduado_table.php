<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosCarreraGraduadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_datos_carrera_graduado', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo', 50);
            $table->string('nombre', 191);
            $table->unsignedInteger('id_tipo');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_tipo')->references('id')->on('tbl_tipos_datos_carrera');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_datos_carrera_graduado');
    }
}
