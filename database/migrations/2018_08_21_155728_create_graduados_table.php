<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraduadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_graduados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identificacion_graduado', 20);
            $table->string('token', 255);
            $table->string('nombre_completo', 50);
            $table->integer('annio_graduacion');
            $table->string('link_encuesta', 255);
            $table->char('sexo', 1);
            $table->unsignedInteger('codigo_carrera');
            $table->unsignedInteger('codigo_universidad');
            $table->unsignedInteger('codigo_grado');
            $table->unsignedInteger('codigo_disciplina');
            $table->unsignedInteger('codigo_area');
            $table->string('tipo_de_caso', 50);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('codigo_carrera')       ->references('id')->on('tbl_datos_carrera_graduado');
            $table->foreign('codigo_universidad')   ->references('id')->on('tbl_datos_carrera_graduado');
            $table->foreign('codigo_grado')         ->references('id')->on('tbl_datos_carrera_graduado');
            $table->foreign('codigo_disciplina')    ->references('id')->on('tbl_datos_carrera_graduado');
            $table->foreign('codigo_area')          ->references('id')->on('tbl_datos_carrera_graduado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_graduados');
    }
}
