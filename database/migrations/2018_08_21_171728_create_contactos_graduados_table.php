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
        // Schema::create('tbl_contactos_graduados', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedInteger('id_graduado');
        //     $table->string('informacion_contacto', 50);
        //     $table->timestamps();
        //     $table->softDeletes();
        //     $table->foreign('id_graduado')->references('id')->on('tbl_graduados');
        // });
        
        Schema::create('tbl_contactos_graduados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identificacion_referencia', 50)->nullable();
            $table->string('nombre_referencia', 191)->nullable();
            // $table->string('informacion_contacto', 191)->nullable();
            // $table->text('observacion_contacto')->nullable();
            $table->string('parentezco', 191)->nullable();
            $table->unsignedInteger('id_graduado');
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
