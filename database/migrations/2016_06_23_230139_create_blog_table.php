<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
class CreateBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                ->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->longText('body');
            $table->dateTime('published_at');
            $table->string('category');
            $table->string('status',20); //draft,published
            $table->timestamps();
        });

        Schema::create('blog_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')
                ->references('id')->on('blog')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('user_id')
                ->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('parent_id')
                ->references('id')->on('blog_comments')->onUpdate('cascade')->onDelete('cascade');
            $table->text('comment');
            $table->timestamps();
        });
        Schema::create('blog_cats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('desc')->nullable();
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
        Schema::drop('blog_cats');
        Schema::drop('blog_comments');
        Schema::drop('blog');
    }
}
