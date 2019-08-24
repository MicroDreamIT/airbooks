<?php

use App\Manufacturer;
use App\Modeled;
use App\Type;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManufacturerTypeModelSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        foreach (range(1, 20) as $index){
            $manufacture = new Manufacturer();
            $manufacture->name = $faker->name;
            $manufacture->type = $faker->randomElement(['aircraft', 'engine', 'apu', 'parts']);
            $manufacture->established = $faker->year;
            $manufacture->country()->associate(random_int(1, 5));
            $manufacture->is_active = $faker->boolean;
            $manufacture->created_at = $faker->date();
            $manufacture->updated_at = $faker->date();
            $manufacture->save();

//            $type=$manufacture->type;
//
//            $ids = \App\Category::where('type',$type)->pluck('id');
//
//            $categories=\App\Category::where('type',$type)
//                ->where('id', $faker->randomElement($ids))->first();
//
//
//            $manufacture->categories()->sync($categories['id']);

            foreach (range(1, 20) as $t){
                $type = new Type();
                $type->name = $faker->name;
                $type->type = $faker->randomElement(['aircraft', 'engine', 'apu', 'parts']);
                $type->is_active = $faker->boolean;
                $type->manufacturer()->associate($manufacture->id);
                $type->created_at = $faker->date();
                $type->updated_at = $faker->date();
                $type->save();
                foreach (range(1, 20) as $w){
                    $modeled = new Modeled();
                    $modeled->name = $faker->unique()->name.$faker->randomNumber(2);
                    $modeled->type = $faker->randomElement(['aircraft', 'engine', 'apu', 'parts']);
                    $modeled->is_active = $faker->boolean;
                    $modeled->type()->associate($type->id);
                    $modeled->created_at = $faker->date();
                    $modeled->updated_at = $faker->date();
                    $modeled->save();
                }
            }
        }
    }
}
