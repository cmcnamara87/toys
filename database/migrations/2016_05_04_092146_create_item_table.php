<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_id');
            $table->string('title');
            $table->integer('year');
            $table->string('gallery_url');
            $table->string('gallery_plus_url');
            $table->string('view_item_url');
            $table->string('currency_id');
            $table->decimal('currency_value');
            $table->string('time_left');
            $table->dateTimeTz('start_time');
            $table->dateTimeTz('end_time');
            $table->integer('cluster_id')->nullable();
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
        Schema::drop('items');
    }
}
