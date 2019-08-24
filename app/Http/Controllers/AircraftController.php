<?php

namespace App\Http\Controllers;

use App\Aircraft;
use App\Airport;
use App\Contact;
use App\Company;
use App\Country;
use App\Http\GlobalMethods;
use App\Http\Requests\AircraftCreateRequest;
use App\Http\Requests\AircraftUpdateRequest;
use App\Http\Traits\searchTrait;
use App\Mail\UserRegistrationCreate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AircraftController extends Controller
{
    use searchTrait;
    public function index(Request $request)
    {

        $query= Aircraft::with('modeled','primaryContact','user.contact.company')->select();

        if( request()->has('fromSection') && request()->input('fromSection')=='user' ) {
            $query->where('user_id', auth()->id());
        }
        if(request()->input('is_active_by_user')) {
            $query->where('is_active_by_user', request()->input('is_active_by_user'));
        }
        if(request()->input('isActiveStatus')){
            $query->where('isActiveStatus', request()->input('isActiveStatus'));
        }
        if(request()->input('title')){
            $this->searchTitle($query);
        }

        return $this->getListForUI($query, $request);
    }


    public function create()
    {
        return response()->json([
            'companies'=>Company::orderBy('name')->select('id', 'name')->get(),
            'user' => Contact::where('user_id', auth()->user()->id)->first(),
            'airports'=>Airport::orderBy('name')->select('id', 'name')->get(),
            'countries'=>Country::orderBy('name')->select('id', 'name')->get(),

        ]);
    }


    public function store(AircraftCreateRequest $request)
    {

        $request->persist();

        return response()->json([
            'type'=>'success',
            'message'=>'Aircraft has been created successfully'
        ]);

    }


    public function show($id)
    {
//        Mail::to('shahanur700@gmail.com')->send(new UserRegistrationCreate());
        $aircraft = Aircraft::with([
            'category:id,name',
            'configuration:id,name',
            'currentLocation',
            'currentOperator',
            'engineModel:id,name',
            'engineType:id,name',
            'engineManufacturer',
            'manufacturer',
            'primaryContact:id,title,first_name,last_name',
            'previousOperator',
            'modeled:id,name',
            'owner:id,name',
            'seller:id,name',
            'manager:id,name',
            'registeredIn:id,name',
            'type:id,name',
            'user.contact.company.specialities',
            'user.contact.jobTitle',
            'medias'
        ])
            ->where('id', $id)->first();

        $aircraft->update([
            'views'=>$aircraft->views+1
        ]);

        $aircraft->views()->create();

        return response()->json(
            $aircraft
        );
    }


    public function edit($id)
    {
        $aircraft=Aircraft::find($id);
        if(Auth::user()->hasRoleType()=='admin' || $aircraft->user_id==auth()->id()) {
            return response()->json([
                'companies' => Company::orderBy('name')->select('id', 'name')->get(),
                'airports' => Airport::orderBy('name')->select('id', 'name')->get(),
                'countries' => Country::orderBy('name')->select('id', 'name')->get(),
                'aircraft' => Aircraft::with([
                    'category:id,name',
                    'configuration:id,name',
                    'currentOperator',
                    'engineModel:id,name',
                    'engineType:id,name',
                    'engineManufacturer',
                    'manufacturer',
                    'primaryContact:id,title,first_name,last_name',
                    'previousOperator',
                    'currentOperator',
                    'modeled:id,name',
                    'owner:id,name',
                    'seller:id,name',
                    'manager:id,name',
                    'registeredIn:id,name',
                    'type:id,name',
                    'user.contact',
                    'registeredIn',
                    'currentLocation',
                    'medias'
                ])
                    ->where('id', $id)->first()

            ]);
        }
    }

    public function update(AircraftUpdateRequest $request, $id)
    {
        $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Aircraft has been Updated successfully'
            ],
            'redirection'=>'/user/aircraft'
        ]);
    }

    public function destroy($id)
    {
        $this->deleteRelatedActivities($id,
            '\\App\\Lead','leadable_id','leadable_type','App\\Aircraft');
        $this->deleteRelatedActivities($id,
            '\\App\\Like','likable_id','likable_type','App\\Aircraft');
        $this->deleteRelatedActivities($id,
            '\\App\\Favourite','favouritable_id','favouritable_type','App\\Aircraft');
        $this->deleteRelatedActivities($id,
            '\\App\\View','viewable_id','viewable_type','App\\Aircraft');

        $aircraft=Aircraft::find($id);
        $aircraft->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Aircraft has been deleted successfully'
            ],
            'redirection'=>'user/aircraft'
        ]);
    }


    public function getSearchData(){
        $query= Aircraft::with('modeled','primaryContact','user.contact.company')->select();

        if (request()->input('is_active_by_user')) {
            $query->where('is_active_by_user', request()->input('is_active_by_user'));
        }
        if (request()->input('isActiveStatus')) {
            $query->where('isActiveStatus', request()->input('isActiveStatus'));
        }
        if(request()->input('title')){
            $this->searchTitle($query);
        }
        if (request()->input('yom_start') && request()->input('yom_end')) {
            if(request()->input('yom_start') == request()->input('yom_end')){
                $query->whereYear('YOM', '=', request()->input('yom_start') );
            }else{
                $query->where(function ($query) {
                    $query->whereYear('YOM', '>=', request()->input('yom_start') )
                        ->whereYear('YOM', '<=', request()->input('yom_end'));
                });
            }


        }
        $query=$this->getDataBySearchQuery($query);
        return $query->paginate(20);
    }

}
