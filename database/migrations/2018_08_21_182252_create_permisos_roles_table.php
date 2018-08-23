<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisosRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('tbl_permisos_roles', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedInteger('id_permiso');
        //     $table->unsignedInteger('id_rol');
        //     $table->timestamps();
        //     $table->softDeletes();
        //     $table->foreign('id_permiso')->references('id')->on('tbl_permisos');
        //     $table->foreign('id_rol')->references('id')->on('tbl_roles');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('tbl_permisos_roles');
    }
}
