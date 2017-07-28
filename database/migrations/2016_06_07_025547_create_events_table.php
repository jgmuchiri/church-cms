<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('allDay')->nullable();
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->string('url')->nullable();
            $table->text('desc')->nullable();
            $table->integer('registration')->nullable();
            $table->string('form_id')->nullable(); //user google forms (url)
            $table->text('options')->nullable();
            $table->string('color')->nullable();
            $table->string('status')->nullable(); //active or private

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
        Schema::drop('events');
    }
}
