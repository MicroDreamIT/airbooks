<?php

namespace App\Http\Controllers;

use App\Continent;
use App\Http\Requests\RegionRequest;
use App\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public $tableName = 'regions';

    public function index()
    {
        $query = $this->joinData('regions', 'continents', 'continent_id');
        if(request()->query('searchValue')){
            $this->inputSearch($query);
        }

        return $this->getListForUIJoin($query);
    }
    public function getRegionNameByContinent()
    {
        return response()->json(
            Region::select('id', 'continent_id', 'name')
                ->where('continent_id', request()->query()['continent_id'])
                ->whereIsActive(1)
                ->orderBy('name')
                ->get()
        );
    }


    public function create()
    {
        return Continent::whereIsActive(1)->get();
    }


    public function store(RegionRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Region has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Region::with('continent')->whereId($id)->first();
    }


    public function edit($id)
    {
        return response()->json([
            'continents'=>Continent::whereIsActive(1)->get(),
            'region'=>Region::with('continent')->whereId($id)->first()
        ]);

    }

    public function update(RegionRequest $request, $id)
    {
        $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Region has been Updated successfully'
            ],
            'redirection'=>'/admin/location/region'
        ]);
    }


    public function destroy($id)
    {
        Region::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Region has been deleted successfully'
            ],
            'redirection'=>'/admin/location/region'
        ]);
    }

    public function lists(){
        $region = Region::select();
        foreach(request()->except(['resultPerPage','page']) as $key=>$value){
            $region->where($key,  $value);
        }

        return response()->json(
            $region->paginate(request()->query()['resultPerPage'])
        );
    }
}
