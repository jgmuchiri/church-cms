<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(SiteSettingsTableSeeder::class);
    }
}
