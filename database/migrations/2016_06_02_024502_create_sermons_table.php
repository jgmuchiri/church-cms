<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
class CreateSermonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sermons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('title');
            $table->string('desc')->nullable();
            $table->longText('message')->nullable();
            $table->string('audio')->nullable();
            $table->string('video')->nullable();
            $table->string('cover')->nullable();
            $table->integer('views')->nullable();
            $table->string('topic')->nullable();
            $table->string('sub_topic')->nullable();
            $table->string('speaker')->nullable();
            $table->string('scripture')->nullable();
            $table->string('status',20);
            $table->timestamps();


            $table->integer('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sermons');
    }
}
