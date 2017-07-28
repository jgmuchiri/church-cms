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
        $menu = ['sermons','ministries','blog','events','account','login'];
        $order=0;
        foreach($menu as $m){
            DB::table('main_menu')->inset(
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
    }
}
