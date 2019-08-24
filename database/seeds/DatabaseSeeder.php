<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(ContinentTableSeeder::class);
//         $this->call(RegionTableSeeder::class);
//         $this->call(CountryTableSeeder::class);
//         $this->call(CategoryTableSeed::class);
//         $this->call(DepartmentSeeders::class);
//         $this->call(TitleSeeders::class);
//         $this->call(CompanySeeder::class);
//         $this->call(UsersTableSeeder::class);
//         $this->call(AircraftSeeders::class);
//         $this->call(AirbookPlanSeeder::class);
//         $this->call(ManufacturerTypeModelSeeders::class);
//         $this->call(ConfigurationSeeders::class);
//         $this->call(FavouriteSeeder::class);
//         $this->call(ConnectionTableSeeder::class);
         $this->call(IntialSetupSeeder::class);
    }
}
