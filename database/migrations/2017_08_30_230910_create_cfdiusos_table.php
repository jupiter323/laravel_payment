<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCfdiusosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creando tabla para catalogo de uss cfdi
        Schema::create('cfdiusos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clave',4);
            $table->string('descripcion',250);
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
        //Borrando tabla
        Schema::dropIfExists('cfdiusos');
    }
}
