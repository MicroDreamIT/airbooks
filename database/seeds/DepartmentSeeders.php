<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeders extends Seeder
{


    public function run()
    {
        $faker = \Faker\Factory::create();

        $data = [];

        for ($i=0; $i<5; $i++){
            DB::table('departments')->insert(
                [
                    'name'=>$faker->name,
                    'type'=>$faker->randomElement([$faker->name, $faker->name]),
                    'is_active'=>$faker->boolean,
                    'created_at'=>$faker->date(),
                    'updated_at'=>$faker->date(),
                ]
            );

        }


    }
}
