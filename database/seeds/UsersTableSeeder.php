<?php

use App\Contact;
use App\Role;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create()->each(function ($u){
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
            $contact->city()->associate($faker->numberBetween(1, 20));
            $contact->creator()->associate($u->id);
            $contact->user()->associate($u->id);
            $contact->jobTitle()->associate($faker->numberBetween(1, 6));
            $contact->department()->associate($faker->numberBetween(1, 5));
            $contact->company()->associate($faker->numberBetween(1, 6));
            $contact->save();

        });
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
        DB::table('role_user')->insert(['user_id'=>2,'role_id'=>2]);
        DB::table('role_user')->insert(['user_id'=>3,'role_id'=>3]);

        $user=\App\User::find(1);
        $user->email='admin@airbook.com';
            $user->update();
          $user=\App\User::find(2);
        $user->email='user@airbook.com';
        $user->update();
        $user=\App\User::find(3);
        $user->email='sub-admin@airbook.com';
        $user->update();

        DB::table('permissions')->insert(['name'=>'create','guard_name'=>'web']);
        DB::table('permissions')->insert(['name'=>'details','guard_name'=>'web']);
        DB::table('permissions')->insert(['name'=>'delete','guard_name'=>'web']);

    }
}
