<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 150)->nullable();
            $table->string('email', 250);
            $table->string('password', 300);
            $table->string('phone', 13)->nullable();
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('address', 250)->nullable();
            $table->string('token', 300)->nullable();
            $table->dateTime('birthday');
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_delete');
            $table->integer('role_id');
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->string('description', 300);
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_delete');
            $table->timestamps();
        });

        Schema::create('feature', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 300);
            $table->string('description', 300)->nullable();
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_delete');
            $table->timestamps();
        });

        Schema::create('role_feature', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->integer('feature_id');
            $table->tinyInteger('create');
            $table->tinyInteger('update');
            $table->tinyInteger('delete');
            $table->tinyInteger('view');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('feature');
        Schema::dropIfExists('role_feature');
    }
}
