<?php

use App\Aircraft;
use App\Apu;
use App\Engine;
use App\Part;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FavouriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =Faker::create();
        $arrayValues=[
            'App\Aircraft',
//            'App\Engine',
//            'App\Apu',
//            'App\Part'
        ];


        $AircraftCount = Aircraft::count();
        $EngineCount = Engine::count();
        $ApuCount = Apu::count();
        $PartCount = Part::count();


        foreach (range(1,20) as $index){
            DB::table('favourites')->insert([
                'user_id'=>$faker->numberBetween(1,2),
                'favouritable_type'=>$value = $faker->randomElements($arrayValues)[0],
                'favouritable_id'=> $faker->numberBetween(1, ${ str_replace('App\\', '',$value).'Count'}),
            ]);
        }

    }
}
