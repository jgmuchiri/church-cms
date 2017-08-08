<?php

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SiteSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Settings::create([
            'name'=>env('APP_NAME'),
            'slogan'=>env('TAG_LINE'),
            'email'=>env('EMAIL_FROM_ADDRESS'),
            'phone'=>'123-333-3444',
            'timezone'=>'EST',
            'currency'=>'USD',
            'date_format'=>'dd-mm-yyyy',
            'google_analytics'=>env('GOOGLE_ANALYTICS')
        ]);

    }
}
