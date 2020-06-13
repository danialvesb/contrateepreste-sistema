<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_chat', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
            $table->integer('solicitation_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('messages_chat', function (Blueprint $table) {
            $table->foreign('solicitation_id')->references('id')->on('solicitations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages_chat');
    }
}
