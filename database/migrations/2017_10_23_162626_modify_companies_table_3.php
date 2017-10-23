<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCompaniesTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //adding new column for company alias
        Schema::table('companies', function (Blueprint $table) {
            $table->string('xsa_domain');
            $table->string('xsa_rfc');
            $table->string('xsa_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //dropping columns
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['xsa_domain','xsa_rfc','xsa_key']);
        });
    }
}
