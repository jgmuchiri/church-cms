<?php

use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules  = ['users','gifts','ministries','sermons','events','birthdays','tickets','mail','blog'];
        foreach($modules as $module){
            \App\Models\Modules::create(
                [
                    'name'=>$module
                ]
            );
        }

    }
}
