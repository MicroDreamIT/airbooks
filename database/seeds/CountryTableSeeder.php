<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =Faker::create();

        foreach (range(1,40) as $index){

            $country = \App\Country::create([
                'name'=>$faker->country,
                'region_id'=>$faker->numberBetween(1,19),
                'continent_id'=>$faker->numberBetween(1,19),
                'currency'=>'BDT',
                'iso_3116_alpha_2'=>45,
                'dialing_code'=>'+88',
                'is_active'=>$faker->numberBetween(0,1),
                'created_at'=>$faker->date(),
                'updated_at'=>$faker->date(),
            ]);

            foreach (range(1, 10) as $state){

                $stat = $country->states()->create([
                    'name'=>$faker->name,
                    'is_active'=>$faker->numberBetween(0,1),
                    'created_at'=>\Carbon\Carbon::parse($faker->date()),
                    'updated_at'=>\Carbon\Carbon::parse($faker->date()),
                ]);
                foreach (range(1, 10) as $city){

                    $stat->cities()->create([
                        'name'=>$faker->city,
                        'is_active'=>$faker->numberBetween(0,1),
                        'created_at'=>\Carbon\Carbon::parse($faker->date()),
                        'updated_at'=>\Carbon\Carbon::parse($faker->date()),
                    ]);

                }
            }
        }
    }
}
