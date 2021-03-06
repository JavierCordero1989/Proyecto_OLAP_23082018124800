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
            $table->string('identificacion_graduado', 20); //Se le quitó atributo para que fuera único ->unique()
            $table->string('token', 191)->unique();
            $table->string('nombre_completo', 50);
            $table->integer('annio_graduacion');
            $table->string('link_encuesta', 191)->unique();
            $table->char('sexo', 2); // M = Hombre, F = Mujer, ND = No Disponible
            $table->unsignedInteger('codigo_carrera');
            $table->unsignedInteger('codigo_universidad');
            $table->unsignedInteger('codigo_grado');
            $table->unsignedInteger('codigo_disciplina');
            $table->unsignedInteger('codigo_area');
            $table->unsignedInteger('codigo_agrupacion');
            $table->unsignedInteger('codigo_sector');
            $table->string('tipo_de_caso', 50);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('codigo_carrera')       ->references('id')->on('tbl_datos_carrera_graduado');
            $table->foreign('codigo_universidad')   ->references('id')->on('tbl_datos_carrera_graduado');
            $table->foreign('codigo_grado')         ->references('id')->on('tbl_datos_carrera_graduado');
            // $table->foreign('codigo_disciplina')    ->references('id')->on('tbl_datos_carrera_graduado');
            // $table->foreign('codigo_area')          ->references('id')->on('tbl_datos_carrera_graduado');
            $table->foreign('codigo_disciplina')    ->references('id')->on('tbl_disciplinas');
            $table->foreign('codigo_area')          ->references('id')->on('tbl_areas');
            $table->foreign('codigo_agrupacion')    ->references('id')->on('tbl_datos_carrera_graduado');
            $table->foreign('codigo_sector')        ->references('id')->on('tbl_datos_carrera_graduado');
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
