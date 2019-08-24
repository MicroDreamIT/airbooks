<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class AirbookPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =Faker::create();
            DB::table('plans')->insert([
                'name'=>'free',
                'title'=>'free',
                'price'=>0,
                'sub_title'=>'Free for ever',
                'position'=>'Left',
                'is_active'=>1,
                'created_at'=>$faker->date(),
                'updated_at'=>$faker->date(),
            ]);
        DB::table('plans')->insert([
            'name'=>'personal',
            'title'=>'$ 25/month',
            'price'=>25,
            'sub_title'=>'$270/year - 10% discount',
            'position'=>'Center',
            'is_active'=>1,
            'created_at'=>$faker->date(),
            'updated_at'=>$faker->date(),
        ]);
        DB::table('plans')->insert([
            'name'=>'corporate',
            'title'=>'$ 120/month',
            'price'=>120,
            'sub_title'=>'$1080/year - 25% discount',
            'position'=>'Right',
            'is_active'=>1,
            'created_at'=>$faker->date(),
            'updated_at'=>$faker->date(),
        ]);
        foreach (range(1,5) as $index){
            DB::table('points')->insert([
                'plan_id'=>1,
                'sub_text'=>$faker->name,
                'created_at'=>$faker->date(),
                'updated_at'=>$faker->date(),
            ]);
        }
        foreach (range(1,5) as $index){
            DB::table('points')->insert([
                'plan_id'=>2,
                'sub_text'=>$faker->name,
                'created_at'=>$faker->date(),
                'updated_at'=>$faker->date(),
            ]);
        }
        foreach (range(1,5) as $index){
            DB::table('points')->insert([
                'plan_id'=>3,
                'sub_text'=>$faker->name,
                'created_at'=>$faker->date(),
                'updated_at'=>$faker->date(),
            ]);
        }

    }
}
