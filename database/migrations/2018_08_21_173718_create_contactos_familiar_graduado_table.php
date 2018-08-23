<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactosFamiliarGraduadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_contactos_familiar_graduado', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_familiar_graduado');
            $table->string('informacion_contacto');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_familiar_graduado')->references('id')->on('tbl_familiar_graduado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_contactos_familiar_graduado');
    }
}
