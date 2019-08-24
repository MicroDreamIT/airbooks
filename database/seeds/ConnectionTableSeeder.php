<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ConnectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =Faker::create();
        foreach (range(1,5) as $index){
            DB::table('connections')->insert([
                'user_id'=>1,
                'conected_user_id'=>$faker->numberBetween(2,5),
                'is_active'=>$faker->numberBetween(0,1),
                'created_at'=>$faker->date(),
                'updated_at'=>$faker->date(),
            ]);
        }
    }
}
