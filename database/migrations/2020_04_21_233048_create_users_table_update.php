<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTableUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo', 100)->default('0')->change();
            $table->string('mobile', 100)->default('0')->change();
            $table->string('city', 100)->default('0')->change();
            $table->string('uf', 100)->default('0')->change();
            $table->string('district', 100)->default('0')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_table_update');
    }
}
