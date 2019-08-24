<?php

namespace App\Http\Controllers\Auth;

use App\Cannedemail;
use App\Company;
use App\Contact;
use App\Http\GlobalMethods;
use App\Http\SendMail;
use App\Mail\UserRegistrationCreate;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
//        $company = json_decode($data['company']);
//
//        dd($company->name);

//        $stoargePath = Storage::disk('public')->put('user', request()->file('profile_photo'));


        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $company = $this->createCompany($data);
        $user = $this->createUser($data);
        $contact = $this->createContact($data, $user, $company);

        DB::table('role_user')->insert(['user_id'=>$user->id,'role_id'=>2]);

        (new SendMail())->sendVerifyEmail($user, $contact);

        return $user;
    }

    /**
     * @param array $data
     * @return mixed
     */
    protected function createUser(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified' => str_random(32),
            'is_active' => 1
        ]);
    }

//    private function generateBirthData($data)
//    {
//        return $data['birthday-month'].'/'.$data['birthday'];
//    }

    /**
     * @param array $data
     * @param $user
     * @param $company
     * @return Contact
     */
    protected function createContact(array $data, $user, $company)
    {
        $contact = new Contact();
        $contact->fill(
            [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'],
                'business_phone' => $data['business_phone'],
                'mobile_phone' => $data['mobile_phone'],
                'birthday' => $data['birthday-month'].'/'.$data['birthday'],
                'email'=>$data['email']
            ]
        );
        $country=json_decode($data['country']);
        $city=json_decode($data['city']);
        $state=json_decode($data['state']);
        $jobTitle=json_decode($data['job_title']);

        if($country){
            $contact->country()->associate($country->id);
        }
        if($state){

            $contact->state()->associate($state->id);
        }
        if($city){
            $contact->city()->associate($city->id);
        }
        if($jobTitle){
            $contact->jobTitle()->associate($jobTitle->id);
        }

        $contact->creator()->associate($user->id);
        $contact->user()->associate($user->id);

//        $contact->department()->associate($data['department']['id']);

        $contact->company()->associate($company->id);

        $contact->save();

        $this->uploadImage($contact);

        return $contact;
    }

    private function createCompany($data)
    {

        $company = json_decode($data['company']);
        if(gettype($company)==='string'){
            return Company::create([
                'name'=>$company
            ]);
        }else{
            if(property_exists($company,'id')){
                return Company::find($company->id);

            }else{
                return Company::create([
                    'name'=>$company->name
                ]);
            }

        }

    }

    private function uploadImage($contact)
    {

        if(request()->file('profile_photo')){
            $filename = request()->file('profile_photo');
            $filename = $filename->getClientOriginalName();
            $path = 'user/'.$contact->id;
            $stoargePath = Storage::disk('public')->put($path, request()->file('profile_photo'));

            $contact->medias()->create(
                [
                    'path' => $path,
                    'original_file_name' => basename($stoargePath),
                    'is_active'=>true,
                    'type'=>request()->file('profile_photo')->getMimeType(),
                    'is_featured'=>false
                ]);
        }
    }

}
