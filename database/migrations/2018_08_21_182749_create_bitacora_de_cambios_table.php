<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitacoraDeCambiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_bitacora_de_cambios', function (Blueprint $table) {
            $table->increments('id');
            $table->char('transaccion', 1);
            $table->string('tabla', 50);
            $table->integer('id_registro_afectado');
            $table->text('dato_original')->nullable();
            $table->text('dato_nuevo')->nullable();
            $table->datetime('fecha_hora_transaccion');
            $table->integer('id_usuario');
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
        Schema::dropIfExists('tbl_bitacora_de_cambios');
    }
}
