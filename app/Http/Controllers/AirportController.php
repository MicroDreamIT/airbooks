<?php

namespace App\Http\Controllers;

use App\Airfield;
use App\Airport;
use App\City;
use App\Country;
use App\Http\Requests\AirportRequest;
use App\Http\Traits\AirportTrait;
use App\Http\Traits\searchTrait;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AirportController extends Controller
{
    use searchTrait,AirportTrait;
    public $tableName='airports';

    public function index()
    {
        $query=$this->getAirportBasedOnJoin();

        if(request()->query('searchValue')){

            $this->inputSearch($query);
        }
        if(request()->input('title')){
            $query->where('airports.name', 'LIKE', '%' . request()->input('title') . '%');
        }
        return $this->getListForUIJoin($query);
    }


    public function create()
    {
        return response()->json([
            'airfields'=>Airfield::whereIsActive(1)->get(),
            'countries'=>Country::whereIsActive(1)->get(),
        ]);
    }


    public function store(AirportRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Airport has been created successfully'
        ]);
    }


    public function show($id)
    {
        $airport = Airport::with(['city.state.country','airfield','user.contact.company','user.contact.jobTitle'])->whereId($id)->first();
        $airport->update([
            'views'=>$airport->views+1
        ]);
        return $airport;
    }


    public function edit($id)
    {
        $airport=Airport::with(['city.state.country', 'airfield'])->whereId($id)->first();
        $stateId = $airport->city->state->id;
        $countryId = $airport->city->state->country->id;
        return response()->json([
            'airport'=> $airport,
            'airfields'=>Airfield::whereIsActive(1)->get(),
            'cities'=>City::whereStateId($stateId)->whereIsActive(1)->get(),
            'states'=>State::whereCountryId($countryId)->whereIsActive(1)->get(),
            'countries'=>Country::whereIsActive(1)->get(),
        ]);
    }

    public function update(AirportRequest $request, $id)
    {
        $airport = $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Airport has been Updated successfully'
            ],
            'redirection'=>'/admin/airport/'.$airport->id
        ]);
    }


    public function destroy($id)
    {
        $this->deleteRelatedActivities($id,
            '\\App\\Lead','leadable_id','leadable_type','App\\Airport');
        $this->deleteRelatedActivities($id,
            '\\App\\Like','likable_id','likable_type','App\\Airport');
        $this->deleteRelatedActivities($id,
            '\\App\\Favourite','favouritable_id','favouritable_type','App\\Airport');
        $this->deleteRelatedActivities($id,
            '\\App\\View','viewable_id','viewable_type','App\\Airport');

        Airport::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Airport has been deleted successfully'
            ],
            'redirection'=>'/admin/airport'
        ]);

    }

    public function lists(){
        $airport = Airport::select();

        foreach(request()->except(['resultPerPage', 'page']) as $key=>$value){
            $airport->where($key,  $value);
        }

        return response()->json(
            $airport->paginate(request()->query()['resultPerPage'])
        );
    }

    public function getSearchData(){

        $query=$this->getAirportBasedOnJoin();

        if (request()->input('is_active_by_user')) {
            $query->where('airports.is_active', request()->input('is_active_by_user'));
        }

        if (request()->input('country')) {
            $this->filterCountry($query,'airports');
        }
        if(request()->input('title')){
            $query->where('airports.name', 'LIKE', '%' . request()->input('title') . '%');
        }
        $query=$this->getDataBySearchQuery($query);
        return $query->paginate(20);
    }
}
