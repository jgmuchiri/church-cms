<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_id');
            $table->string('name');
            $table->string('slogan')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('poc')->nullable();
            $table->string('stripe_public')->nullable();
            $table->string('stripe_secret')->nullable();
            $table->integer('stripe_is_active')->nullabe();
            $table->string('paypal_email')->nullable();
            $table->integer('paypal_is_active')->nullable();
            $table->string('timezone')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('date_format')->nullable();
            $table->string('google_analytics')->nullable();
            $table->integer('allow_registration')->nullable();
            $table->string('logo')->nullable();
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
        Schema::drop('settings');
    }
}
