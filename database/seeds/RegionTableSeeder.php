<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RegionTableSeeder extends Seeder
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
            DB::table('regions')->insert([
                'name'=>$faker->name,
                'continent_id'=>$faker->numberBetween(1,19),
                'is_active'=>$faker->numberBetween(0,1),
                'created_at'=>$faker->date(),
                'updated_at'=>$faker->date(),
            ]);
        }
    }
}
