<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactosGraduadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_contactos_graduados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_graduado');
            $table->string('informacion_contacto', 50);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_graduado')->references('id')->on('tbl_graduados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_contactos_graduados');
    }
}
