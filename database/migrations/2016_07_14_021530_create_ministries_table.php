<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMinistriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ministries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('category_id',false,true)->nullable();
            $table->longText('desc');
            $table->integer('active');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('ministry_cats')->onDelete('set null');
        });

        Schema::create('ministry_cats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->longText('desc')->nullable();
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
        Schema::drop('ministry_cats');
        Schema::drop('ministries');
    }
}
