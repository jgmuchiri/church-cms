<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question');
            $table->string('question_desc')->nullable();
            $table->text('answer')->nullable();
            $table->integer('category');
            $table->string('active');
            $table->integer('upvote')->nullable();
            $table->integer('downvote')->nullable();
            $table->timestamps();
        });
        Schema::create('kb_cats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('desc')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order');
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
        Schema::drop('kb');
        Schema::drop('kb_cats');
    }
}
