<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_asignaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_graduado');
            $table->unsignedInteger('id_encuestador');
            $table->unsignedInteger('id_supervisor');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_graduado')->references('id')->on('tbl_graduados');
            $table->foreign('id_encuestador')->references('id')->on('users');
            $table->foreign('id_supervisor')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_asignaciones');
    }
}
