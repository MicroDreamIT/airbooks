<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
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

            DB::table('specialities')->insert([
                'name'=>$faker->unique()->jobTitle,
                'is_active'=>$faker->boolean,
                'created_at'=>$faker->date(),
                'updated_at'=>$faker->date(),
            ]);

            DB::table('companies')
                ->insert([
                    'name'=>$faker->userName,
                    'status'=>true,
                    'city_id'=>random_int(1, 20),
                    'created_at'=>$faker->date(),
                    'updated_at'=>$faker->date(),
                ]);


        }
    }
}
