<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategoryTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $faker =Faker::create();
       $arrayValues=['aircraft', 'apu', 'engine'];
       foreach (range(1,20) as $index){
           DB::table('categories')->insert([
               'type'=>$arrayValues[rand(0,2)],
               'name'=>$faker->name,
               'description'=>$faker->text(50),
               'is_active'=>$faker->numberBetween(0,1),
               'created_at'=>$faker->date(),
               'updated_at'=>$faker->date(),
           ]);
       }

    }
}
