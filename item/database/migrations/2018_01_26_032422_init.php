<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 300);
            $table->integer('parent_id');
            $table->integer('group_item');
            $table->string('description', 500);
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_delete');
            $table->timestamps();
        });

        Schema::create('group_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 300);
            $table->string('description', 500);
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_delete');
            $table->timestamps();
        });

        Schema::create('html_view', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 300);
            $table->text('content');
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_delete');
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 500);
            $table->string('image', 100);
            $table->string('description', 500);
            $table->text('content');
            $table->float('price', 8, 2);
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_delete');
            $table->timestamps();
        });

        Schema::create('item_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->text('addition_info');
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_delete');
            $table->timestamps();
        });

        Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('value', 500);
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_delete');
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

    }
}