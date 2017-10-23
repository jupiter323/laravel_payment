<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXsaresterrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xsaresterrors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alias_consult',255);
            $table->string('code',4);
            $table->string('error',255);
            $table->string('descripction',255);
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
        Schema::dropIfExists('xsaresterrors');
    }
}
