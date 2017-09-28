<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //adding new columns for invoicing assistant
        Schema::table('companies', function (Blueprint $table) {
            $table->string('subject');
            $table->text('message');
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
            $table->dropColumn(['subject', 'message']);
        });
    }
}
