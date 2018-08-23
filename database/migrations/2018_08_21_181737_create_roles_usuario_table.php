<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('tbl_roles_usuario', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedInteger('id_rol');
        //     $table->unsignedInteger('id_usuario');
        //     $table->timestamps();
        //     $table->softDeletes();
        //     $table->foreign('id_rol')->references('id')->on('tbl_roles');
        //     $table->foreign('id_usuario')->references('id')->on('tbl_usuarios');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('tbl_roles_usuario');
    }
}
