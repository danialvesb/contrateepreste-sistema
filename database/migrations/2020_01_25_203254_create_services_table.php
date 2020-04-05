<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('description', 102);
            $table->string('image_path', 100);
            $table->timestamps();
        });
//        Schema::table('services', function (Blueprint $table) {
//            $table->foreign('file_group')->references('id')
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files_relations_offer');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('services');
    }
}
