<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create(config('password_history.table_name'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('guard', 20);
            $table->string('password', 80);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('password_history.table_name'));
    }
}
