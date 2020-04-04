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
        Schema::create('services_files', function (Blueprint $table) {
            $table->integer('service_id');
            $table->integer('file_id');
            $table->timestamps();
        });
//        Schema::table('services_files', function (Blueprint $table) {
//            $table->foreign('service_id')->references('id')->on('services');
//            $table->foreign('file_id')->references('id')->on('files');
//        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services_files');
    }
}
