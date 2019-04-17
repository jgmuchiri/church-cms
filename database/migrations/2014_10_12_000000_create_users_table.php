<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->string('first_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('email',100)->unique();
            $table->string('password',60);

            $table->boolean('confirmed')->default(0);
            $table->string('activation_code')->nullable();
            $table->string('confirmation_code')->nullable();

            $table->text('address')->nullable();
            $table->string('phone',20)->nullable();
            $table->string('photo')->nullable();
            $table->date('dob')->nullable();
            $table->integer('status')->default(1); //0 - inactive 1-active 2-suspended

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
