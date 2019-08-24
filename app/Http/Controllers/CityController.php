<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\CityRequest;
use App\State;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public $tableName = 'cities';

    public function index()
    {
        $query = $this->joinData('cities', 'states', 'state_id');
        if(request()->query('searchValue')){
            $this->inputSearch($query);
        }

        return $this->getListForUIJoin($query);
    }

    public function getCityNameByState()
    {
        return response()->json(
            City::select('id', 'state_id', 'name')
                ->where('state_id', request()->query()['state_id'])
                ->whereIsActive(1)
                ->orderBy('name')
                ->get()
        );
    }

    public function create()
    {
        return State::whereIsActive(1)->get();
    }


    public function store(CityRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'City has been created successfully'
        ]);
    }


    public function show($id)
    {
        return City::with('state')->whereId($id)->first();
    }


    public function edit($id)
    {
        return response()->json([
            'states'=>State::whereIsActive(1)->get(),
            'region'=>City::with('state')->whereId($id)->first()
        ]);

    }

    public function update(CityRequest $request, $id)
    {
        $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'City has been Updated successfully'
            ],
            'redirection'=>'/admin/location/city'
        ]);
    }


    public function destroy($id)
    {
        City::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'City has been deleted successfully'
            ],
            'redirection'=>'/admin/location/city'
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
