<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('main_menu')->truncate();
        $menu = ['sermons','ministries','blog','events','account','login'];
        $order=0;
        foreach($menu as $m){
            DB::table('main_menu')->insert(
                [
                    'title'=>ucwords($m),
                    'path'=>'/'.$m,
                    'parent'=>0,
                    'active'=>1,
                    'order'=>$order

                ]
            );
            $order++;
        }

        $this->command->info("Default menu has been created!");
    }
}
