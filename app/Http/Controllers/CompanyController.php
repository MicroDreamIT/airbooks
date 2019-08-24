<?php

namespace App\Http\Controllers;

use App\City;
use App\Company;
use App\Contact;
use App\Country;
use App\Http\Requests\CompanyRequest;
use App\Http\Traits\CompanyTrait;
use App\Http\Traits\searchTrait;
use App\News;
use App\Speciality;
use App\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    use searchTrait,CompanyTrait;
    public $tableName = 'companies';

    public function index()
    {
        $query=$this->getCompanyDataBasedOnJoin();

        if(request()->query('is_active')){
            $query->where('companies.is_active', request()->query('is_active'));
        }

        if(request()->query('searchValue')){
            $this->inputSearch($query);
        }
        if(request()->input('title')){
            $query->where('companies.name', 'LIKE', '%' . request()->input('title') . '%');
        }
        return $this->getListForUIJoin($query,'companies.id');
    }


    public function create()
    {
        return response()->json([
            'countries'=>Country::whereIsActive(1)->get(),
            'specialities'=>Speciality::whereIsActive(1)->get()
        ]);
    }


    public function store(CompanyRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Company has been created successfully'
        ]);
    }


    public function show($id)
    {
        $company=Company::with(['city','state','country','specialities', 'medias', 'contact'])->whereId($id)->first();

        $company->update([
            'views' => $company->views?$company->views + 1:0+1
        ]);

        return $company;
    }

    public function edit($id=null)
    {
        if (strpos(request()->url(), 'user') !== false) {
          $userWithCompany=User::with('contact.company')->whereId(Auth::user()->id)->first();
            $company = Company::with(['city','state','country','specialities','medias'])
                ->whereId($userWithCompany->contact->company->id)->first();
        }else{
            $company = Company::with(['city','state','country','specialities','medias'])->whereId($id)->first();
        }



        return response()->json([
            'company'=> $company,
            'cities'=>City::whereStateId($company->state_id)->whereIsActive(1)->get(),
            'states'=>State::whereCountryId($company->country_id)->whereIsActive(1)->get(),
            'countries'=>Country::whereIsActive(1)->get(),
            'specialities'=>Speciality::whereIsActive(1)->get()
        ]);

    }

    public function update(CompanyRequest $request, $id)
    {

        $company = $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Company has been Updated successfully'
            ],
            'redirection'=>'/admin/company/'.$company->id
        ]);
    }


    public function destroy($id)
    {
        $contact = Contact::where('company_id', $id)->select();
        $news = News::where('company_id', $id)->select();


        if($contact->exists() || $news->exists()){
            return response()->json([
                'message'=>[
                    'type'=>'danger',
                    'message'=>'You can not delete this company because it exists in other table'
                ],
            ]);
        }

        $company=Company::with('specialities')->whereId($id)->first();
        $specialityIds=[];
        foreach ($company->specialities as $speciality){
            $specialityIds[]=$speciality['id'];
        }
        $company->specialities()->detach($specialityIds);
        $company->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'The record has been deleted.'
            ],
            'redirection'=>'/admin/company'
        ]);
    }

    public function lists(){

        $company = Company::select();
        foreach(request()->except(['resultPerPage','page']) as $key=>$value){
            $company->where($key,  $value);
        }

        return response()->json(
            $company->paginate(request()->query()['resultPerPage'])
        );
    }


    public function updateFromUser($id){

        $company=Company::find($id);
        $company->name=request()->input('name');
        $company->rfq_email=request()->input('rfq_email');
        $company->aog_email=request()->input('aog_email');
        $company->save();
        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Company has been Updated successfully'
            ],
        ]);
    }



    public function getSearchData(){

        $query=$this->getCompanyDataBasedOnJoin();
        $query->groupBy('companies.id');

        if (request()->input('is_active_by_user')) {
            $query->where('companies.is_active', request()->input('is_active_by_user'));
        }

        if (request()->input('country')) {
            $this->filterCountry($query,'companies');
        }
        if (request()->input('speciality')) {
            $this->filterSpeciality($query,'company_speciality');
        }
        if(request()->input('title')){
            $query->where('companies.name', 'LIKE', '%' . request()->input('title') . '%');
        }
        $query=$this->getDataBySearchQuery($query);
        return $query->paginate(20);
    }
}
