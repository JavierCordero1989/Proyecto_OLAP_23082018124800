<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarioCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_calendario_de_citas', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('fecha_hora');
            $table->string('numero_contacto', 50);
            $table->text('observacion')->nullable();
            $table->char('estado', 1); // P: pendiente, L: lista
            $table->unsignedInteger('id_encuestador');
            $table->unsignedInteger('id_entrevista')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_encuestador')->references('id')->on('users');
            $table->foreign('id_entrevista')->references('id')->on('tbl_graduados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_calendario_de_citas');
    }
}
