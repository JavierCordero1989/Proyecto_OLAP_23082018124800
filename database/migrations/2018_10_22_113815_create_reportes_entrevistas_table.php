<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportesEntrevistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_reportes_entrevistas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('codigo_disciplina');
            $table->unsignedInteger('codigo_grado');
            $table->unsignedInteger('codigo_universidad');
            $table->string('tipo_de_caso', 50);
            $table->integer('total_casos');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('codigo_disciplina')  ->references('id')->on('tbl_disciplinas');
            $table->foreign('codigo_grado')       ->references('id')->on('tbl_datos_carrera_graduado');
            $table->foreign('codigo_universidad') ->references('id')->on('tbl_datos_carrera_graduado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_reportes_entrevistas');
    }
}
