<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesRelationsOffer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_relations_offer', function (Blueprint $table) {
            $table->integer('offer_id')->unsigned();
            $table->integer('file_id')->unsigned();
        });
        Schema::table('files_relations_offer', function (Blueprint $table) {
            $table->foreign('offer_id')->references('id')->on('offers')
                ->onDelete('cascade');;
            $table->foreign('file_id')->references('id')->on('files')
                ->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('files');
    }
}
