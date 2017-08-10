<?php

use App\Models\Themes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('themes')->truncate();
        Themes::create([
            'name'=>'Blue Light',
            'desc'=>'Blue light theme',
            'location'=>'blue-light',
            'active'=>1
        ]);
    }
}
