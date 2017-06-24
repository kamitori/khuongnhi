<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('user_type_id')->unsigned()->default(0);
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('primary_color', 10)->default('#4EA0CF');
            $table->string('menu_color', 10)->default('#383f48');
            $table->string('confirmation_code');
            $table->boolean('confirmed')->default(false);
            $table->boolean('admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}
