<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_detalle_contacto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contacto', 191)->nullable();
            $table->text('observacion')->nullable();
            $table->char('estado', 1); // F => Funcional, E => Eliminado
            $table->unsignedInteger('id_contacto_graduado');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_contacto_graduado')->references('id')->on('tbl_contactos_graduados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_detalle_contacto');
    }
}
