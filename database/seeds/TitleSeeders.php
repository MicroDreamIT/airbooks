<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TitleSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=\Faker\Factory::create();
        for ($i=0;$i<6;$i++){

            DB::table('titles')->insert([
                'name'=>$faker->unique()->jobTitle,
                'is_active'=>$faker->boolean,
                'created_at'=>$faker->date(),
                'updated_at'=>$faker->date(),
            ]);
        }
    }
}
