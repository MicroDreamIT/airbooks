<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker= Factory::create();

        foreach (range(1, 20) as $index){
            DB::table('configurations')->insert([
                'name'=> $faker->name,
                'is_active' => $faker->boolean
            ]);
        }
    }
}