<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =Faker::create();

        foreach (range(1,20) as $index){
            DB::table('continents')->insert([
                'name'=>$faker->name,
                'is_active'=>$faker->numberBetween(0,1),
                'created_at'=>$faker->date(),
                'updated_at'=>$faker->date(),
            ]);

        }
    }
}
