<?php

namespace App\Http\Controllers;

use App\Company;
use App\Contact;
use App\Country;
use App\Engine;
use App\Http\Requests\EngineRequest;
use App\Http\Requests\EngineUpdateRequest;
use App\Http\Traits\searchTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EngineController extends Controller
{
    use searchTrait;

    public function index()
    {
        $query= Engine::with('contact','user.contact.company')->select();

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
        return $this->getListForUI($query, request());
    }


    public function create()
    {
        return response()->json([
            'companies'=>Company::whereIsActive(1)->orderBy('name')->select('id', 'name')->get(),
            'countries'=>Country::whereIsActive(1)->orderBy('name')->select('id', 'name')->get(),
            'user' => Contact::where('user_id', auth()->user()->id)->first(),
        ]);
    }


    public function store(EngineRequest $request)    {
	     
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Engine has been created successfully'
        ]);
    }

    public function show($id)
    {
        $engine = Engine::with([
            'category:id,name',
            'manufacturer:id,name',
            'type:id,name',
            'model:id,name',
            'contact.company.specialities',
            'currentLocation:id,name',
            'owner:id,name',
            'seller:id,name',
            'medias',
            'user.contact.jobTitle',
            'user.contact.company.specialities'

        ])->whereId($id)->first();

        $engine->update([
            'views'=>$engine->views + 1
        ]);

        $engine->views()->create();

        return $engine;
    }


    public function edit($id)
    {
        $engine=Engine::find($id);
        if(Auth::user()->hasRoleType()=='admin' || $engine->user_id==auth()->id()) {
            return response()->json([
                'companies' => Company::whereIsActive(1)->orderBy('name')->select('id', 'name')->get(),
                'countries' => Country::whereIsActive(1)->orderBy('name')->select('id', 'name')->get(),
                'engine' => Engine::with([
                    'category:id,name',
                    'manufacturer:id,name',
                    'type:id,name',
                    'model:id,name',
                    'contact:id,first_name,last_name',
                    'currentLocation:id,name',
                    'owner:id,name',
                    'seller:id,name',
                    'medias'

                ])->whereId($id)->first()

            ]);
        }
    }


    public function update(EngineUpdateRequest $request, $id)
    {
        $request->updatePersist($id);


        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Engine has been Updated successfully'
            ],
            'redirection'=>'/user/Engine'
        ]);
    }

    public function destroy($id)
    {
        $this->deleteRelatedActivities($id,
            '\\App\\Lead','leadable_id','leadable_type','App\\Engine');
        $this->deleteRelatedActivities($id,
            '\\App\\Like','likable_id','likable_type','App\\Engine');
        $this->deleteRelatedActivities($id,
            '\\App\\Favourite','favouritable_id','favouritable_type','App\\Engine');

        $this->deleteRelatedActivities($id,
            '\\App\\View','viewable_id','viewable_type','App\\Engine');

        $aircraft=Engine::find($id);
        $aircraft->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Engine has been deleted successfully'
            ],
            'redirection'=>'user/engine'
        ]);
    }

    public function getSearchData(){
        $query= Engine::with('contact','user.contact.company')->select();

        if (request()->input('is_active_by_user')) {
            $query->where('is_active_by_user', request()->input('is_active_by_user'));
        }
        if (request()->input('isActiveStatus')) {
            $query->where('isActiveStatus', request()->input('isActiveStatus'));
        }
        if(request()->input('title')){
            $this->searchTitle($query);
        }

        if(request()->input('cycle_remaining_from')==0 && request()->input('cycle_remaining_to')){
            $from=(int)request()->input('cycle_remaining_from');
            $to=(int)request()->input('cycle_remaining_to');
            $query->whereBetween('cycle_remaining',[$from==0?$from:$from-1,$to==0?$to:$to+1]);
        }
        $query=$this->getDataBySearchQuery($query);
        return $query->paginate(20);
    }
}
