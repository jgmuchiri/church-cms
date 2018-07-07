<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMinistryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ministries', function (Blueprint $table) {
            $table->string('name')->unique()->change();
            if(Schema::hasColumn('ministries','slug')){
                $table->dropColumn(['slug']);
            }
        });

        Schema::table('ministry_cats', function (Blueprint $table) {
            $table->string('name')->unique()->change();
            if(Schema::hasColumn('ministry_cats','slug')){
                $table->dropColumn(['slug']);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ministries', function (Blueprint $table) {
            $table->string('slug');
            $table->dropUnique(['name']);
        });
        Schema::table('ministry_cats', function (Blueprint $table) {
            $table->string('slug');
            $table->dropUnique(['name']);
        });
    }
}
