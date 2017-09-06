<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->truncate();
        $modules  = ['profile','users','gifts','ministries','sermons','events','birthdays','tickets','mail','blog','logs','settings'];
        foreach($modules as $module){
            $this->command->info("Creating  module ".$module);
            \App\Models\Modules::create(
                [
                    'name'=>$module
                ]
            );
        }

        $this->command->info("All modules have been created!");
    }
}
