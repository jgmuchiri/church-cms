<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blog_cats')->truncate();
        DB::table('blog_cats')->insert(
            [
                'name'=>'default',
                'desc'=>'Default category'
            ]
        );
    }
}
