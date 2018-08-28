<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactosFamiliarGraduadoFamiliarGraduadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('tbl_contactos_familiarGraduado', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedInteger('id_familiar_graduado');
        //     $table->unsignedInteger('id_graduado');
        //     $table->timestamps();
        //     $table->softDeletes();
        //     $table->foreign('id_familiar_graduado')->references('id')->on('tbl_familiar_graduado');
        //     $table->foreign('id_graduado')->references('id')->on('tbl_graduados');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('tbl_contactosFamiliarGraduado_familiarGraduado');
    }
}
