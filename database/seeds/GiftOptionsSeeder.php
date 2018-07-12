<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GiftOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gift_options')->truncate();
        $options = [
            [
                'name' => 'Offering',
                'desc' => 'General offerings',
                'amount'=>null,
                'active' => 1
            ],
            [
                'name' => 'Tithe',
                'desc' => 'Tithe',
                'amount'=>null,
                'active' => 1
            ],
            [
                'name' => 'Children ministry',
                'desc' => 'Children ministry',
                'amount' => 50,
                'active' => 1
            ]
        ];
        foreach($options as $option){
            $opt= new \App\Models\Giving\GiftOptions();
            $opt->name = $option['name'];
            $opt->amount = $option['amount'];
            $opt->desc=$option['desc'];
            $opt->active =$option['active'];
            $opt->save();
        }
    }
}
