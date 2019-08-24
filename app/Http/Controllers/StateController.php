<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\StateRequest;
use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{

    public $tableName = 'states';

    public function index()
    {
        $query = $this->joinData('states', 'countries', 'country_id');
        if(request()->query('searchValue')){
            $this->inputSearch($query);
        }

        return $this->getListForUIJoin($query);
    }

    public function getStateNameByCountry()
    {
        return response()->json(
            State::select('id', 'country_id', 'name')
                ->where('country_id', request()->query()['country_id'])
                ->whereIsActive(1)
                ->orderBy('name')
                ->get()
        );
    }


    public function create()
    {
        return Country::whereIsActive(1)->get();
    }


    public function store(StateRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'State has been created successfully'
        ]);
    }


    public function show($id)
    {
        return State::with('country')->whereId($id)->first();
    }


    public function edit($id)
    {
        return response()->json([
            'countries'=>Country::whereIsActive(1)->get(),
            'state'=>State::with('country')->whereId($id)->first()
        ]);

    }

    public function update(StateRequest $request, $id)
    {
        $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'State has been Updated successfully'
            ],
            'redirection'=>'/admin/location/state'
        ]);
    }


    public function destroy($id)
    {
        State::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'State has been deleted successfully'
            ],
            'redirection'=>'/admin/location/state'
        ]);
    }

    public function lists(){
        $city = City::select();
        foreach(request()->except(['resultPerPage','page']) as $key=>$value){
            $city->where($key,  $value);
        }

        return response()->json(
            $city->paginate(request()->query()['resultPerPage'])
        );
    }
}
