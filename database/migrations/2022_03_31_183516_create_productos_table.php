<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre_producto');
            $table->string('codigo_producto');
            $table->string('nro_parte_producto')->nullable();
            $table->string('publicado_producto')->default('0')->nullable();
            $table->string('cant_producto')->nullable();
            $table->string('precio_producto')->nullable();
            $table->string('id_categoria')->nullable();
            $table->string('estatus_producto')->default('1');
            $table->string('deleted_producto')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
