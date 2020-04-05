<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_relation_solicitation', function (Blueprint $table) {
            $table->integer('solicitation_id')->unsigned();
            $table->integer('file_id')->unsigned();
        });
        Schema::table('files_relation_solicitation', function (Blueprint $table) {
            $table->foreign('solicitation_id')->references('id')->on('solicitations')
                ->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')
                ->onDelete('cascade');  ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
