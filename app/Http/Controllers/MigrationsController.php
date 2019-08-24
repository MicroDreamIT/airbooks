<?php

namespace App\Http\Controllers;

use App\Aircraft;
use App\Airport;
use App\Category;
use App\City;
use App\Contact;
use App\Country;
use App\Engine;
use App\Like;
use App\Manufacturer;
use App\Modeled;
use App\News;
use App\State;
use App\Title;
use App\Type;
use App\User;
use App\Wanted;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;
use Illuminate\Support\Str;

class MigrationsController extends Controller
{
    public function index()
    {

        $old_database = DB::connection('mysql2');
        Model::unguard();
//        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

//        $this->companyTableMigrations($old_database);
////        $this->wantedTableMigrations($old_database);
////        $this->userTableMigrations($old_database);
////        $this->contactTableMigrations($old_database);
////        $this->aircraftTableMigrations($old_database);
////        $this->airportTableMigrations($old_database);
////        $this->newsTableMigrations($old_database);
////        $this->apuTableMigrations($old_database);
////        $this->leadTableMigrations($old_database);
////        $this->engineTableMigrations($old_database);
////        $this->aircraftMsn();
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();

    }

    private function airportTableMigrations($old_database)
    {
        $old_airports = $old_database->table('airports');


//        $old_airports = $old_airports
//            ->where('id', '<',5900)
//            ->where('id', '>',5800)
//            ->get();

//        $city = City::where('name', 'like', 'Sondrestrom'.'%')->first();


//        DB::table('airports')->truncate();

        foreach ($old_airports as $old_airport) {

            $country = Country::with('states.cities')->where('name', 'like', $old_airport->country . '%')->first();
            $country_id = 0;
            if ($country) {
                $country_id = $country->id;
            }
            $state_id = 0;
            $city_id = 0;

            if ($country) {
                $cities = City::where('name', 'like', $old_airport->city . '%')->get();

                foreach ($cities as $city) {

                    $state = State::with('cities')->whereHas('cities', function ($dataCity) use ($city) {
                        $dataCity->where('id', $city->id);
                    })->where('country_id', $country->id)->first();

                    if ($state) {
                        $state_id = $state->id;
                        $city_id = $city->id;
                    }
                }
            }

//                echo var_dump($country_id, $state_id, $city_id), '<br>';

            if ($country_id) {
                Airport::create([
                    'id' => $old_airport->id,
                    'user_id' => 1,
                    'name' => $old_airport->title,
                    'city_id' => $city_id ? $city_id : 209806,
                    'country_id' => $country_id,
                    'state_id' => $state_id ? $state_id : 112274,
                    'iata_code' => $old_airport->iata,
                    'icao_code' => $old_airport->icao,
                    'airfield_type_id' => 2,
                    'is_published' => true
                ]);
            }

        }
    }

    /**
     * @param $old_database
     */
    public function companyTableMigrations($old_database)
    {
        $old_companies = $old_database->table('companies');
        $old_companies = $old_companies->where('id','>', 660)->get();

//        $old_specialities = $old_database->table('company_specialties');
//        $old_specialities = $old_specialities->get();
        $old_company_speciality_pivots = $old_database->table('comp_spec_link');
        $old_company_speciality_pivots = $old_company_speciality_pivots->where('comp_id','>', 660)->get();


//        $this->specialityMigrations($old_specialities);
//        $this->companyMigrations($old_companies);
        $this->companySpecialityMigrations($old_company_speciality_pivots);

//        dd($old_companies, $old_company_speciality_pivots);
    }

    /**
     * @param $old_specialities
     */
    public function specialityMigrations($old_specialities)
    {
        DB::table('specialities')->truncate();
        foreach ($old_specialities as $old_speciality) {
            DB::table('specialities')->insert([
                'id' => $old_speciality->id,
                'name' => $old_speciality->title,
                'is_active' => $old_speciality->isactive,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),

            ]);
        }
    }

    /**
     * @param $old_companies
     */
    public function companyMigrations($old_companies)
    {
//        DB::table('companies')->truncate();
//        DB::table('medias')->truncate();
        foreach ($old_companies as $old_company) {

            $companyId = DB::table('companies')->insertGetId([

                'id' => $old_company->id,
                'name' => $old_company->title ? $old_company->title : 'N/A',
                'status' => 1,
                'profile' => $old_company->details,
                'zip_code' => $old_company->zipcode,
                'po_box' => $old_company->pobox,
                'business_phone' => $old_company->tel,
                'address' => $old_company->address,
                'city_id' => $old_company->city,
                'state_id' => $old_company->state,
                'country_id' => $old_company->country,
                'logo' => '',
                'website' => $old_company->website,
                'is_active' => $old_company->isactive,
                'is_published' => 1,
                'views' => 0,
                'rfq_email' => $old_company->email,
                'aog_email' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            if ($old_company->logo) {
                DB::table('medias')->insert([
                    'mediable_type' => 'App\Company',
                    'mediable_id' => $companyId,
                    'path' => 'old',
                    'original_file_name' => $old_company->logo,
                    'is_active' => 1,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }

        }
    }

    /**
     * @param $old_company_speciality_pivots
     */
    public function companySpecialityMigrations($old_company_speciality_pivots)
    {
//        DB::table('company_speciality')->truncate();
        foreach ($old_company_speciality_pivots as $old_company_speciality_pivot) {
            DB::table('company_speciality')->insert([
                'company_id' => $old_company_speciality_pivot->comp_id,
                'speciality_id' => $old_company_speciality_pivot->cat_id
            ]);
        }
    }

    private function conditionsTableMigrations($old_database)
    {
        $old_conditions = $old_database->table('condition_set');
        $old_conditions = $old_conditions->get();
        DB::table('conditions')->truncate();
        foreach ($old_conditions as $old_condition) {
            DB::table('conditions')->insertGetId([
                'id' => $old_condition->id,
                'name' => $old_condition->title,
                'is_active' => 1,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        }
    }

    private function wantedTableMigrations($old_database)
    {
        $old_wanteds = $old_database->table('wanted_listing');
        $old_wanteds = $old_wanteds->get();
        DB::table('wanteds')->truncate();

        foreach ($old_wanteds as $old_wanted) {

            $uid = null;
            $manufacturer = null;
            $types = null;
            $model = null;

            $uid = 'ABW' . $old_wanted->id;

            if ($old_wanted->wanted_type == 1) {
                $type = 'aircraft';
                if ($old_wanted->wanted_man && $old_wanted->wanted_t) {
                    list($manufacturer, $types, $model) = $this->getModelRelations('aircraft', $old_wanted, $old_database);
                }
            } elseif ($old_wanted->wanted_type == 2) {
                $type = 'engine';
                if ($old_wanted->wanted_man && $old_wanted->wanted_t) {
                    list($manufacturer, $types, $model) = $this->getModelRelations('engine', $old_wanted, $old_database);
                }
            } elseif ($old_wanted->wanted_type == 3) {
                $type = 'parts';
            } else {
                $type = 'apu';
                if ($old_wanted->wanted_man && $old_wanted->wanted_t) {
                    list($manufacturer, $types, $model) = $this->getModelRelations('apu', $old_wanted, $old_database);
                }
            }


            if ($old_wanted->wanted_terms == 1) {
                $offer_for = 'Sale';
            } elseif ($old_wanted->wanted_terms == 2) {
                $offer_for = 'Lease';
            } elseif ($old_wanted->wanted_terms == 3) {
                $offer_for = 'ACMI';
            } elseif ($old_wanted->wanted_terms == 4) {
                $offer_for = 'Dry Lease';
            } elseif ($old_wanted->wanted_terms == 5) {
                $offer_for = 'Wet Lease';
            } elseif ($old_wanted->wanted_terms == 6) {
                $offer_for = 'Exchange';
            } elseif ($old_wanted->wanted_terms == 7) {
                $offer_for = 'cash';
            } else {
                $offer_for = '';
            }

            if ($type != 'parts' && $old_wanted->wanted_man && $old_wanted->wanted_t) {
                $modeltitle = !$model ? '' : $model->name;
                $title = str_replace(' ', '-', $manufacturer->name)
                    . str_replace(' ', '-', '-' . $types->name . '-')
                    . $modeltitle
                    . '-wanted-for-' . $offer_for;
            } else {
                $title = str_replace(' ', '-', $old_wanted->part_no . '-wanted-for-' . $offer_for);
            }


            if ($type != 'parts' && $old_wanted->wanted_man && $old_wanted->wanted_t) {
                $wanted = Wanted::create([
                    'id' => $old_wanted->id,
                    'title' => $title,
                    'uid' => $uid,
                    'user_id' => $old_wanted->listed_by,
                    'type' => $type,
                    'manufacturer_id' => $manufacturer ? $manufacturer->id : null,
                    'type_id' => $types ? $types->id : null,
                    'model_id' => $model ? $model->id : null,
                    'part_number' => $old_wanted ? $old_wanted->part_no : null,
                    'yom' => $old_wanted->yom == '0000' ? '2000' : $old_wanted->yom,
                    'terms' => $offer_for,
                    'country_id' => 249,
                    'comments' => $old_wanted->comments,
                    'primary_contact' => $old_wanted->listed_by,
                    'wanted_by' => $old_wanted->listed_by
                ]);
            }
            if ($type == 'parts') {
                $wanted = Wanted::create([
                    'id' => $old_wanted->id,
                    'title' => $title,
                    'uid' => $uid,
                    'user_id' => $old_wanted->listed_by,
                    'type' => $type,
                    'manufacturer_id' => $manufacturer ? $manufacturer->id : null,
                    'type_id' => $types ? $types->id : null,
                    'model_id' => $model ? $model->id : null,
                    'part_number' => $old_wanted ? $old_wanted->part_no : null,
                    'yom' => $old_wanted->yom == '0000' ? '2000' : $old_wanted->yom,
                    'terms' => $offer_for,
                    'country_id' => 249,
                    'comments' => $old_wanted->comments,
                    'primary_contact' => $old_wanted->listed_by,
                    'wanted_by' => $old_wanted->listed_by
                ]);
            }
        }


    }

    private function userTableMigrations($old_database)
    {
        $old_users = $old_database->table('users');
        $old_users = $old_users->get();
//        DB::table('users')->truncate();
//        User::create(['email' => 'admin@airbook.com', 'email_verified' => '',
//            'is_active' => 1, 'password' => '$2y$12$gsmjCHRYA7V8EgrBUn2Hnu0z0nLIdbVROHcaWHvmldz7I9khFfv8u']);
//        DB::table('role_user')->insert(['user_id' => 1, 'role_id' => 1]);
        $existing = 593;
        foreach ($old_users as $old_user) {
            $new_password = str_random(8);
            if($old_user->id>582){
//                echo ++$existing,'<br>';
                $userId = DB::table('users')->insertGetId([
                'id' => $existing++,
                'email' => $old_user->email,
                'email_verified' => $old_user->emailvalidation ? '' : str_random(32),
                'is_active' => $old_user->isactive,
                'new_password' => $new_password,
                'password' => Hash::make($new_password),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            DB::table('role_user')->insert([
                'user_id' => $userId, 'role_id' => 2,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
            }
        }
    }

    private function contactTableMigrations($old_database)
    {
        $old_contacts = $old_database->table('contacts');
        $old_contacts = $old_contacts->get();
//        DB::table('contacts')->truncate();

//        $faker = Factory::create();
        $contact = new Contact();
//        $contact->first_name = $faker->firstName;
//        $contact->last_name = $faker->lastName;
////            $contact->birthday = $faker->numberBetween(1, 12). '-' . $faker->numberBetween(1, 12);
//        $contact->title = $faker->randomElement(
//            [
//                'Dr', 'Esq', 'Hon', 'Jr', 'Mr',
//                'Mrs', 'Ms', 'Messrs', 'Mmes',
//                'Msgr', 'Prof', 'Rev', 'Rt. Hon', 'Sr', 'St'
//            ]);
//
//        $contact->gender = $faker->randomElement([
//            'male', 'female', 'other'
//        ]);
////            $contact->preferred_contact_method = 'email';
//        $contact->created_at = $faker->date();
//        $contact->updated_at = $faker->date();
//        $contact->creator()->associate(1);
//        $contact->user()->associate(1);
//        $contact->company()->associate(1);
//        $contact->save();
        $existing_id = 593;

        foreach ($old_contacts as $old_contact) {
            if($old_contact->user_id>582){
                if ($old_contact->bday) {
                    $birthday = substr($old_contact->bday, 5);
                } elseif ($old_contact->bday === '0000-00-00') {
                    $birthday = null;
                } else {
                    $birthday = null;
                }

                if ($old_contact->title == 'Miss') {
                    $title = 'Miss';
                } elseif (!$old_contact->title) {
                    $title = 'Mr';
                } else {
                    $title = $old_contact->title;
                }
                $jobtitleid = Title::where('name', 'like', $old_contact->jobtitle . '%')->first();
//            dd($jobtitleid, $old_contact->department);


                $contact = Contact::create([
                    'creator_id' => $existing_id,
                    'user_id' => $existing_id,
                    'email' => $old_contact->email,
                    'title' => $title,
                    'company_id' => $old_contact->company_name,
                    'first_name' => $old_contact->fname,
                    'last_name' => $old_contact->lname,
                    'gender' => $old_contact->gender == 1 ? 'male' : $old_contact->gender == 0 ? 'female' : $old_contact->gender,
                    'birthday' => $birthday,
                    'job_title' => $jobtitleid ? $jobtitleid->id : null,
                    'business_phone' => $old_contact->bphone,
                    'mobile_phone' => $old_contact->mphone,
                    'skype' => $old_contact->skypeid,
                    'linkedin' => $old_contact->linkedin,
                    'address' => $old_contact->address,
                    'city_id' => $old_contact->city,
                    'country_id' => $old_contact->country,
                    'state_id' => $old_contact->state,
                    'preferred_contact_method' => 'Email',
                    'is_primary' => $old_contact->primary,
                    'is_public' => 1
                ]);
                if ($old_contact->profile_pic) {
                    DB::table('medias')->insert([
                        'mediable_type' => 'App\Contact',
                        'mediable_id' => $contact->id,
                        'path' => 'old',
                        'original_file_name' => $old_contact->profile_pic,
                        'is_active' => 1,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
                }
            $existing_id++;
            }
        }
    }

    private function aircraftTableMigrations($old_database)
    {

        $old_aircrafts = $old_database->table('aircraft');
        $old_aircrafts = $old_aircrafts->get();
        DB::table('aircrafts')->truncate();


        foreach ($old_aircrafts as $old_aircraft) {
            if ($old_aircraft->offered_for == 1) {
                $offer_for = 'Sale';
            } elseif ($old_aircraft->offered_for == 2) {
                $offer_for = 'Lease';
            } elseif ($old_aircraft->offered_for == 3) {
                $offer_for = 'ACMI';
            } elseif ($old_aircraft->offered_for == 4) {
                $offer_for = 'Dry Lease';
            } elseif ($old_aircraft->offered_for == 5) {
                $offer_for = 'Wet Lease';
            } else {
                $offer_for = '';
            }
            if ($old_aircraft->status == 1) {
                $status = 'Storage';
            } elseif ($old_aircraft->status == 2) {
                $status = 'Parking';
            } elseif ($old_aircraft->status == 3) {
                $status = 'Operational';
            } elseif ($old_aircraft->status == 4) {
                $status = 'For Tear Down';
            } else {
                $status = null;
            }


            $oldcat = $old_database->table('aircraft_cat')->find($old_aircraft->cat_id)->title;

            $catid = Category::where('type', 'aircraft')->where('name', $oldcat)->first();

            $oldman = $old_database->table('aircraft_manufacturer')->find($old_aircraft->man_id)->title;

            $oldtype = $old_database->table('aircraft_type')->find($old_aircraft->type_id)->title;

            $oldmodel = $old_database->table('aircraft_model')->find($old_aircraft->model_id)->title;


            $manufacturer = Manufacturer::where('type', 'aircraft')->where('name', $oldman)->first();


            $type = Type::where('type', 'aircraft')->where('name', $oldtype)->first();


            $model = Modeled::where('type', 'aircraft')->where('name', $oldmodel);
            if ($model->exists()) {
                $modelname = '-' . $model->first()->name;
                $modelid = $model->first()->id;
            } else {
                $model = null;
            }


            $title = str_slug($manufacturer->name . '-' . $type->name . $modelname . '-available-for-' . $offer_for);
            $uid = 'ABA' . $old_aircraft->id;


            if ($old_aircraft->e_man_id) {
                $engineoldman = $old_database->table('engine_man')->find($old_aircraft->e_man_id)->title;

                $engine_manufacturer = Manufacturer::where('type', 'engine')->where('name', $engineoldman);

                if ($engine_manufacturer->exists()) {
                    $engine_manufacturer_id = $engine_manufacturer->first()->id;
                } else {
                    $engine_manufacturer_id = null;
                }

            } else {
                $engine_manufacturer_id = null;
            }

            if ($old_aircraft->e_type_id) {
                $engine_type = $old_database->table('engine_type')->find($old_aircraft->e_type_id)->title;
                $engine_type = Type::where('type', 'engine')->where('name', $engine_type);
                if ($engine_type->exists()) {
                    $engine_type_id = $engine_type->first()->id;
                } else {
                    $engine_type_id = null;
                }
            } else {
                $engine_type_id = null;
            }

            if ($old_aircraft->e_model_id) {
                $engine_model = $old_database->table('engine_model')->find($old_aircraft->e_model_id)->title;
                $engine_model = Modeled::where('type', 'engine')->where('name', $engine_model);
                if ($engine_model->exists()) {
                    $engine_model_id = $engine_model->first()->id;
                } else {
                    $engine_model_id = null;
                }

            } else {
                $engine_model_id = null;
            }

            $aircraft = Aircraft::create([
                'id' => $old_aircraft->id,
                'title' => $title,
                'uid' => $uid,
                'user_id' => $old_aircraft->manager,

                'category_id' => $catid->id,

                'type_id' => $type->id,
                'engine_type_id' => $engine_type_id,
                'engine_model_id' => $engine_model_id,
                'engine_manufacturer_id' => $engine_manufacturer_id,
                'model_id' => $modelid,
                'manufacturer_id' => $manufacturer->id,
                'MSN' => $old_aircraft->msn,
                'YOM' => $old_aircraft->yom,
                'offer_for' => $offer_for,
                'mgh' => $old_aircraft->mgh_acmi,
                'price' => $old_aircraft->asking_price,
                'availability' => $old_aircraft->availability_date,
                'status' => $status, //['Storage', 'Parking', 'Operational', 'For Tear Down']

                'owner_id' => $old_aircraft->owner,
                'manager_id' => $old_aircraft->manager,
                'seller_id' => $old_aircraft->seller,
                'primary_contact' => $old_aircraft->primary_contact,
                'current_location' => null,
                'configuration_id' => $old_aircraft->aircraft_config,
                'tsn' => $old_aircraft->total_time,
                'csn' => $old_aircraft->total_cycles,
                'mtow' => $old_aircraft->mtow,
                'mlgw' => $old_aircraft->mlgw,
                'last_c_check' => null,
                'promotion_date' => null,
                'compliance' => 'TBA',
                'description' => $old_aircraft->comments,
                'promote_status' => false,
                'isActiveStatus' => 'Pending Approval',
            ]);
            $old_media_table = $old_database->table('media');
            $old_media_table = $old_media_table->where('belogs_to_type', 'aircraft')->where('belogs_to_id', $old_aircraft->id)->first();


            if ($old_media_table != null) {
                if ($old_media_table->path) {
                    DB::table('medias')->insert([
                        'mediable_type' => 'App\Aircraft',
                        'mediable_id' => $aircraft->id,
                        'path' => 'old',
                        'original_file_name' => $old_media_table->path,
                        'is_active' => 1,
                        'is_featured' => $old_media_table->type == 'featuredImage' ? 1 : false,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
                }
            }

        }
    }

    private function newsTableMigrations($old_database)
    {
        $old_news = $old_database->table('news');
        $old_news = $old_news->get();
        DB::table('news')->truncate();
        DB::table('category_news')->truncate();
        foreach ($old_news as $old_new) {
            $news = News::create([
                'id' => $old_new->id,
                'title' => $old_new->title,
                'date' => Carbon::parse($old_new->n_date)->toDateTimeString(),
                'company_id' => $old_new->comp_id ? $old_new->comp_id : 8,
                'continent_id' => $old_new->continentId ? $old_new->continentId : 8,
                'region_id' => $old_new->reagionId ? $old_new->reagionId : 29,
                'source' => $old_new->source,
                'details' => $old_new->details
            ]);
            $old_media_table = $old_database->table('media');
            $old_media_table = $old_media_table->where('belogs_to_type', 'like', 'news' . '%')->where('belogs_to_id', $old_new->id)->first();

            if ($old_media_table != null) {
                if ($old_media_table->path) {
                    DB::table('medias')->insert([
                        'mediable_type' => 'App\News',
                        'mediable_id' => $news->id,
                        'path' => 'old',
                        'original_file_name' => $old_media_table->path,
                        'is_active' => 1,
                        'is_featured' => $old_media_table->type === 'featuredImage' ? 1 : false,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
                }
            }

        }
        $old_news_links = $old_database->table('new_cat_link');
        $old_news_links = $old_news_links->get();


        foreach ($old_news_links as $old_news_link) {
            $cat_id = 0;
            if ($old_news_link->cat_id == 2) {
                $cat_id = 20;
            }
            if ($old_news_link->cat_id == 3) {
                $cat_id = 19;
            }
            if ($old_news_link->cat_id == 4) {
                $cat_id = 18;
            }
            if ($old_news_link->cat_id == 5) {
                $cat_id = 17;
            }
            DB::table('category_news')->insert([
                'news_id' => $old_news_link->news_id,
                'category_id' => $cat_id
            ]);
        }

//        new   old
//         20 - 2
//          19  3
//      18 - 4
//        17-5
//
    }

    private function leadTableMigrations($old_database)
    {
//        1 aircraft
//        2 engine
//        3 spare parts
//        4 apu
    }

    private function apuTableMigrations($old_database)
    {

    }

    private function engineTableMigrations($old_database)
    {
        $old_engines = $old_database->table('engine');
        $old_engines = $old_engines->get();
        DB::table('engines')->truncate();

//        status
//    1   Storage
//    3   Operational
//    4   For Tear Down

        foreach ($old_engines as $old_engine) {

            if ($old_engine->offered_for == 1) {
                $offer_for = 'Sale';
            } elseif ($old_engine->offered_for == 2) {
                $offer_for = 'Lease';
            } elseif ($old_engine->offered_for == 6) {
                $offer_for = 'Exchange';
            } else {
                $offer_for = '';
            }
            if ($old_engine->status == 1) {
                $status = 'storage';
            } elseif ($old_engine->status == 3) {
                $status = 'operational';
            } elseif ($old_engine->status == 4) {
                $status = 'for tear down';
            } else {
                $status = null;
            }


            $oldcat = $old_database->table('engine_cat')->find($old_engine->e_cat)->title;

            $cat_id = Category::where('type', 'engine')->where('name', $oldcat)->first();


            $title = '';
            $engine_manufacturer_name = '';
            $engine_type_name = '';
            $engine_model_name = '';
            $engine_manufacturer_id = null;
            $engine_type_id = null;
            if ($old_engine->e_man) {
                $engineoldman = $old_database->table('engine_man')->find($old_engine->e_man)->title;

                $engine_manufacturer = Manufacturer::where('type', 'engine')->where('name', $engineoldman)->first();

                if ($engine_manufacturer) {
                    $engine_manufacturer_name = $engine_manufacturer->name;
                    $engine_manufacturer_id = $engine_manufacturer->id;
                } else {
                    $engine_manufacturer_id = null;
                }

            } else {
                $engine_manufacturer_id = null;
            }

            if ($old_engine->e_type) {
                $engine_type = $old_database->table('engine_type')->find($old_engine->e_type)->title;
                $engine_type = Type::where('type', 'engine')->where('name', $engine_type)->first();
                if ($engine_type) {
                    $engine_type_name = $engine_type->name;
                    $engine_type_id = $engine_type->id;
                } else {
                    $engine_type_id = null;
                }
            } else {
                $engine_type_id = null;
            }
            $modelname = '';
            if ($old_engine->e_model) {
                $engine_model = $old_database->table('engine_model')->find($old_engine->e_model)->title;
                $engine_model = Modeled::where('type', 'engine')->where('name', $engine_model)->first();
                if ($engine_model) {
                    $modelname = '-' . $engine_model->name;
                    $engine_model_id = $engine_model->id;
                } else {
                    $engine_model_id = null;
                }

            } else {
                $engine_model_id = null;
            }
            $title = str_slug($engine_manufacturer_name . '-' . $engine_type_name . $modelname . '-available-for-' . $offer_for);


            $engine = Engine::create([
                'id' => $old_engine->id,
                'uid' => 'ABE' . $old_engine->id,
                'title' => $title,
                'user_id' => $old_engine->listed_by,
                'manufacturer_id' => $engine_manufacturer_id,
                'category_id' => $cat_id->id,
                'type_id' => $engine_type_id,
                'model_id' => $engine_model_id,
                'offer_for' => $offer_for,
                'esn' => $old_engine->esn,
                'status' => $status,
                'availability' => Carbon::parse($old_engine->availability_date)->toDateTimeString(),
                'price' => $old_engine->asking_price ? $old_engine->asking_price : 0,
                'description' => $old_engine->comments,
                'owner_id' => $old_engine->listed_by,
                'seller_id' => $old_engine->listed_by,
                'primary_contact' => $old_engine->listed_by,
                'isActiveStatus' => $old_engine->esn ? 'Approved' : 'Pending Approval'
            ]);

            $old_media_table = $old_database->table('media');
            $old_media_table = $old_media_table->where('belogs_to_type', 'like', 'engine' . '%')->where('belogs_to_id', $old_engine->id)->first();

            if ($old_media_table != null) {
                if ($old_media_table->path) {
                    DB::table('medias')->insert([
                        'mediable_type' => 'App\Engine',
                        'mediable_id' => $old_engine->id,
                        'path' => 'old',
                        'original_file_name' => $old_media_table->path,
                        'is_active' => 1,
                        'is_featured' => $old_media_table->type === 'featuredImage' ? 1 : false,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
                }
            }

        }
    }

    private function getModelRelations($type, $old_wanted, $old_database)
    {
        if ($type == 'aircraft') {
            $old_man = 'aircraft_manufacturer';
            $old_type = 'aircraft_type';
            $old_model = 'aircraft_model';
            $new_model = 'aircraft';
        } elseif ($type == 'engine') {
            $old_man = 'engine_man';
            $old_type = 'engine_type';
            $old_model = 'engine_model';
            $new_model = 'engine';
        } else {
            $old_man = 'apu_man';
            $old_type = 'apu_type';
            $old_model = 'apu_model';
            $new_model = 'apu';
        }

        $oldman = $old_database->table($old_man)->find($old_wanted->wanted_man)->title;

        $oldtype = $old_database->table($old_type)->find($old_wanted->wanted_t)->title;


        $manufacturer = Manufacturer::where('type', $new_model)->where('name', $oldman)->first();


        $type = Type::where('type', $new_model)->where('name', $oldtype)->first();

        if ($old_wanted->wanted_m > 0) {
            $oldmodel = $old_database->table($old_model)->find($old_wanted->wanted_m);
        } else {
            $oldmodel = null;
        }

        if ($oldmodel) {
            $model = Modeled::where('type', $new_model)->where('name', $oldmodel->title)->first();
        } else {
            $model = null;
        }
        return [$manufacturer, $type, $model];
    }

    private function aircraftMsn()
    {

        $extracteds = ['0000', '00000', 'oooo', '----', '---', 'xxxxx', '--', 'TBA', 'TBN', 'TBD', 'N', '0', 'xxxxxxx'];


        $aircrafts = Aircraft::whereNotIn('MSN', $extracteds)->get();

        foreach ($aircrafts as $aircraft) {
            Aircraft::whereId($aircraft->id)->first()->update(['isActiveStatus' => 'Approved']);
        }

        $aircrafts = Aircraft::all();

        foreach ($aircrafts as $aircraft) {
            $aircraft->update(['YOM' => $aircraft->YOM . '-03-05 05:19:11']);
        }

        dd('done');
    }

}
