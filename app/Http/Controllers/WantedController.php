<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Country;
use App\Http\Requests\WantedRequest;
use App\Http\Requests\WantedUpdateRequest;
use App\Http\Traits\searchTrait;
use App\Lead;
use App\Wanted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WantedController extends Controller
{
    use searchTrait;
    public function index()
    {
        $query= Wanted::with('contact','user.contact.company')->select();

        if( request()->has('fromSection') && request()->input('fromSection')=='user' ) {
            $query->where('user_id', auth()->id());
        }
        if(request()->input('is_active')) {
            $query->where('is_active', request()->input('is_active'));
        }
        if(request()->input('title')){
            $this->searchTitle($query);
        }

        return $this->getListForUI($query, request());
    }

    public function create()
    {
        return response()->json([
            'user' => Contact::where('user_id', auth()->user()->id)->first(),
            'countries'=>Country::whereIsActive(1)->get(),
            ]);
    }

    public function store(WantedRequest $request)
    {
//        return $request->all();
	    $request->createPersist();
	    return response()->json([
		    'type'=>'success',
		    'message'=>'Wanted has been created successfully'
	    ]);
    }

    public function show($id)
    {
        $wanted = Wanted::whereId($id)->first();
        $wanted->update(['views'=>$wanted->views+1]);
        $wanted->views()->create();
	    return response()->json([
		    'wanted'=>Wanted::with([
			    'contact.company.specialities',
			    'manufacturer:id,name',
			    'typed:id,name',
			    'modeled:id,name',
                'user.contact.company.specialities',
                'user.contact.jobTitle',
                'country'
		    ])->whereId($id)->first()
	
	    ]);
        return $wanted;
    }

    public function edit($id)
    {
        $wanted=Wanted::find($id);
        if(Auth::user()->hasRoleType()=='admin' || $wanted->user_id==auth()->id()) {
            return response()->json([
                'wanted' => Wanted::with([
                    'contact:id,first_name,last_name',
                    'manufacturer:id,name',
                    'typed:id,name',
                    'modeled:id,name',
                    'country'

                ])->whereId($id)->first(),
                'countries' => Country::whereIsActive(1)->get()

            ]);
        }

    }


    public function update(WantedUpdateRequest $request, $id)
    {
        $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Wanted has been Updated successfully'
            ],
            'redirection'=>'/user/wanted'
        ]);
    }


    public function destroy($id)
    {
        $this->deleteRelatedActivities($id,
            '\\App\\Lead','leadable_id','leadable_type','App\\Wanted');
        $this->deleteRelatedActivities($id,
            '\\App\\Like','likable_id','likable_type','App\\Wanted');
        $this->deleteRelatedActivities($id,
            '\\App\\Favourite','favouritable_id','favouritable_type','App\\Wanted');
        $this->deleteRelatedActivities($id,
            '\\App\\View','viewable_id','viewable_type','App\\Wanted');


        $wanted=Wanted::find($id);
        $wanted->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Wanted has been deleted successfully'
            ],
            'redirection'=>'user/wanted'
        ]);
    }

    public function getSearchData(){
        $query= Wanted::with('contact','user.contact.company')->select();
        if (request()->input('is_active_by_user')) {
            $query->where('is_active', request()->input('is_active_by_user'));
        }
        if(request()->input('title')){
            $this->searchTitle($query);
        }
        $query=$this->getDataBySearchQuery($query,'wanted');
        return $query->paginate(20);
    }
}
