<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('tbl_usuarios', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('nombre_completo', 255);
        //     $table->string('correo_electronico', 255);
        //     $table->string('contrasennia', 255);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('tbl_usuarios');
    }
}
