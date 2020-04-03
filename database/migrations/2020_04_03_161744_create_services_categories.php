<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_categories', function (Blueprint $table) {
            $table->integer('service_id')->unsigned();
            $table->integer('category_id')->unsigned();
        });

        Schema::table('services_categories', function (Blueprint $table) {
            $table->foreign('service_id')->references('id')
                ->on('services')
                ->onDelete('cascade')
                ->onUpdate('restrict');
            $table->foreign('category_id')->references('categories')
                ->on('id')
                ->onDelete('cascade')
                ->onUpdate('restrict');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services_categories');
    }
}
