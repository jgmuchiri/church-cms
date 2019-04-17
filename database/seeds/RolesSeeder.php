<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'manager',
            'staff',
            'member',
            'volunteer'
        ];

        \App\Models\Roles::truncate();

        foreach($roles as $role){
            \App\Models\Roles::create(
                [
                    'name'=>$role,
                    'description'=>$role.' role'
                ]
            );
        }
    }
}
