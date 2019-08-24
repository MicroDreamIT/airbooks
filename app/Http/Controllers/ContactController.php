<?php

namespace App\Http\Controllers;

use App\Company;
use App\Contact;
use App\Department;
use App\Http\Requests\ContactCreateRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\SendMail;
use App\Http\Traits\searchTrait;
use App\Media;
use App\Title;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{

    use searchTrait;
    public function index(Request $request)
    {

        $query = Contact::with('user','jobTitle','company')->select();

        if($request->input('is_published')){
            $query->where('is_published', $request->input('is_published'));
        }

        if(array_key_exists('user_id', request()->query())){
            $query->where('creator_id', request()->input('user_id'));
        }
        if(array_key_exists('creator_id', request()->query())){

            $query->where('creator_id', request()->input('creator_id'));
        }

        if(array_key_exists('auth', request()->query())){
            $query->where('creator_id', auth()->id());
        }
        if(array_key_exists('only_user_based_contact', request()->query())){
           $query->where('user_id','!=',null);
        }
        if(request()->input('title')){
            $value=request()->input('title');
            $query->whereRaw("concat(first_name, ' ', last_name) like '%$value%' ");

        }
        return $this->getListForUI($query, $request);
    }


    public function create()
    {
        return response()->json([
            'departments' => DB::table('departments')
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),

            'titles' => DB::table('titles')
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),

            'companies' => DB::table('companies')
                ->select('id', 'name')
                ->orderBy('name')
                ->get()
        ]);

    }


    public function store(ContactCreateRequest $request)
    {
        $contact = $request->createPersist();

        $content = [];

        $content = [
            'name'=>$contact->first_name.' '.$contact->last_name,
            'body'=>auth()->user()->contact->fullName.' has been added you in there contact, please register to be a member in airbook',
            'url'=>url('/register')
        ];


        (new SendMail())->cannedEmail($contact->email, auth()->user()->contact->fullName,url('/register'), 'contact-create');

//        (new SendMail())->objectContent($contact->email, auth()->user()->contact->fullName.' has added you', $content);
//
//        dd($content);
        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Contact has been Updated successfully'
            ],
            'redirection'=>'/admin/contacts/'.$contact->id
        ]);
    }


    public function show($id)
    {
        $contact = Contact::with([
            'user.contact',
            'creator',
            'medias',
            'jobTitle',
            'company.specialities',
            'department',
            'state',
            'country',
            'city'])->whereId($id)->first();

        $contact->update([
            'views'=>$contact->views + 1
        ]);

        return response()->json($contact);

    }

    public function edit($id)
    {
        $contact=Contact::find($id);
        if(Auth::user()->hasRoleType()=='admin' || $contact->user_id==auth()->id()){
            return response()->json([
                'departments'=>Department::whereIsActive(1)->get(),
                'titles'=>Title::whereIsActive(1)->get(),
                'companies'=>Company::whereIsActive(1)->get(),
                'contact'=>Contact::with([
                    'user',
                    'creator',
                    'medias',
                    'jobTitle',
                    'company',
                    'department',
                    'city',
                    'country',
                    'state'
                ])->whereId($id)->first()
            ]);
        }

    }


    public function update(ContactUpdateRequest $request, $id)
    {
        $contact=Contact::find($id);
        if(Auth::user()->hasRoleType()=='admin' || $contact->user_id==auth()->id()){

            $contact = $request->updateContact($id);
            return response()->json([
                'message'=>[
                    'type'=>'success',
                    'message'=>'Contact has been Updated successfully'
                ],
                'redirection'=>'/admin/contacts/'.$contact->id
            ]);

        }

    }



    public function destroy($id)
    {
        if(auth()->id()==$id){
            return 'You are not able to do your own contact';
        }else{
            Contact::whereId($id)->first()->delete();
            return 'Contact has been deleted successfully';
        }

    }


    public function accountSetting(Request $request){
        $contactData=json_decode(request()->input('contact'),true);
        $file=request()->file('file');
        $contact =Contact::whereId($contactData['id'])->first();
        $contact->fill($contactData);
        $contact->city()->associate($contactData['city']['id']);
        $contact->state()->associate($contactData['state']['id']);
        $contact->country()->associate($contactData['country']['id']);
        $contact->jobTitle()->associate($contactData['job_title']['id']);
        $contact->department()->associate($contactData['department']['id']);
        $contact->company()->associate($contactData['company']['id']);
        $contact->save();
        if($file){
            $media=Media::whereMediableId($contact->id)->whereMediableType('App\Contact')->first();
            $storeImage=Storage::disk('public')->put('Contact', $file);
            $fileName=str_replace('Contact/','',$storeImage);
            if($media){
                Storage::disk('public')->delete($media->path.'/'.$media->original_file_name);
                $media->update([
                    'original_file_name'=>$fileName
                ]);
            }else{
                Media::create([
                    'mediable_type'=>'App\Contact',
                    'mediable_id'=>$contact->id,
                    'type'=>'image/jpeg',
                    'path'=>'Contact',
                    'original_file_name'=>$fileName
                ]);
            }

        }
        return response()->json([
            'type'=>'success',
            'message'=>'Account information update successfully'

        ]);

    }

    public function updateProfileDeatils(){

        $setting=json_decode(request()->input('setting'));
        $file=request()->file('file');
        $user=User::find(Auth::id());
        if(property_exists($setting,'current_password')){
            if(property_exists($setting,'new_password')){
                if(Hash::check($setting->current_password, $user->password)){
                    $user->update(["password"=>Hash::make($setting->new_password)]);

                }else{
                    return response()->json([
                        'type'=>'danger',
                        'message'=>'Current Password is not correct.'
                    ]);
                }
            }else{
                return response()->json([
                    'type'=>'danger',
                    'message'=>'Please Enter New password to change your password.'

                ]);
            }

        }
        $contact=Contact::whereUserId(Auth::id())->first();
        $contact->update([
            'first_name'=>$setting->first_name,
            'last_name'=>$setting->last_name,
        ]);
        if($file){
            $media=Media::whereMediableId($contact->id)->whereMediableType('App\Contact')->first();
            $storeImage=Storage::disk('public')->put('user/'.$contact->id, $file);
            $fileName=str_replace('user/'.$contact->id,'',$storeImage);
            if($media){
                Storage::disk('public')->delete($media->path.'/'.$media->original_file_name);
                $media->update([
                    'original_file_name'=>$fileName
                ]);
            }else{
                Media::create([
                    'mediable_type'=>'App\Contact',
                    'mediable_id'=>$contact->id,
                    'type'=>'image/jpeg',
                    'path'=>'user/'.$contact->id,
                    'original_file_name'=>$fileName
                ]);
            }

        }
        return response()->json([
            'type'=>'success',
            'message'=>'Account information update successfully'

        ]);






    }




    public function getSearchData(){
        $query = Contact::with('user','jobTitle','company')->select();

        if (request()->input('is_active_by_user')) {
            $query->where('is_published', request()->input('is_active_by_user'));
        }
        if(array_key_exists('only_user_based_contact', request()->query())){
            $query->where('user_id','!=',null);
        }
        if (request()->input('country')) {
            $this->filterCountry($query);
        }

        if (request()->input('creator')) {
            $query->whereCreatorId(request()->input('creator'));
        }
        if (request()->input('company')) {
            $query->whereCompanyId(request()->input('company'));
        }


        if(request()->input('title')){
            if(request()->input('title')){
                $value=request()->input('title');
                $query->whereRaw("concat(first_name, ' ', last_name) like '%$value%' ");

            }
        }

        $query=$this->getDataBySearchQuery($query);
        return $query->paginate(20);
    }
}
