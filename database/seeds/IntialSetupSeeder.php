<?php

use Illuminate\Database\Seeder;
use App\Contact;
use App\Role;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class IntialSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\User::create(['email'=>'admin@airbook.com','email_verified'=>'',
            'is_active'=>1, 'password'=>'$2y$12$gsmjCHRYA7V8EgrBUn2Hnu0z0nLIdbVROHcaWHvmldz7I9khFfv8u']);
        \App\Company::create(['name'=>'Airbook']);

            $faker = Factory::create();
            $contact = new Contact();
            $contact->first_name = $faker->firstName;
            $contact->last_name = $faker->lastName;
//            $contact->birthday = $faker->numberBetween(1, 12). '-' . $faker->numberBetween(1, 12);
            $contact->title = $faker->randomElement(['Dr', 'Esq', 'Hon', 'Jr', 'Mr', 'Mrs', 'Ms', 'Messrs', 'Mmes', 'Msgr', 'Prof', 'Rev', 'Rt. Hon', 'Sr', 'St']);
            $contact->gender =$faker->randomElement(['male', 'female', 'other']);
//            $contact->preferred_contact_method = 'email';
            $contact->created_at = $faker->date();
            $contact->updated_at = $faker->date();
            $contact->creator()->associate(1);
            $contact->user()->associate(1);
            $contact->company()->associate(1);
            $contact->save();


        $role= new \App\Roled();
        $role->name='admin';
        $role->guard_name='web';
        $role->save();

        $role= new \App\Roled();
        $role->name='user';
        $role->guard_name='web';
        $role->save();

        $role= new \App\Roled();
        $role->name='sub-admin';
        $role->guard_name='web';
        $role->save();

        DB::table('role_user')->insert(['user_id'=>1,'role_id'=>1]);


        DB::table('permissions')->insert(['name'=>'create','guard_name'=>'web']);
        DB::table('permissions')->insert(['name'=>'edit','guard_name'=>'web']);
        DB::table('permissions')->insert(['name'=>'details','guard_name'=>'web']);
        DB::table('permissions')->insert(['name'=>'delete','guard_name'=>'web']);

//        \App\Seo::create(['model_id'=>1,
//            'model_type'=>'Home',
//            'method'=>'index',
//            'title'=>'Home',
//            'description'=>'Home page Description',
//            'is_active'=>1
//        ]);
    }
}
