<?php

namespace App\Http\Controllers;

use App\Continent;
use App\Country;
use App\Http\Requests\CountryRequest;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    public $tableName = 'countries';

    public function index()
    {
        $query=DB::table('countries')
            ->select('countries.name', 'countries.id', 'countries.is_active', 'continents.name as continent_name', 'regions.name as region_name')
            ->leftJoin('continents', 'countries.continent_id','=','continents.id')
            ->leftJoin('regions', 'countries.region_id','=','regions.id');
        if(request()->query('searchValue')){
            $this->inputSearch($query);
        }

        return $this->getListForUIJoin($query);
    }

    public function create()
    {
        return response()->json([
            "continents" => Continent::whereIsActive(1)->get(),
            "regions" => Region::whereIsActive(1)->get(),
        ]);
    }


    public function store(CountryRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Country has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Country::with(['continent','region', 'medias'])->whereId($id)->first();
    }


    public function edit($id)
    {
        return response()->json([
            'continents'=>Continent::whereIsActive(1)->get(),
            'regions'=>Region::whereIsActive(1)->get(),
            'country'=>Country::with(['continent','region','medias'])->whereId($id)->first()
        ]);

    }

    public function update(CountryRequest $request, $id)
    {
        $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Country has been Updated successfully'
            ],
            'redirection'=>'/admin/location/country'
        ]);
    }


    public function destroy($id)
    {
        Country::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Country has been deleted successfully'
            ],
            'redirection'=>'/admin/location/country'
        ]);
    }

    public function lists(){
        $country = Country::select();
        foreach(request()->except(['resultPerPage','page']) as $key=>$value){
            $country->where($key,  $value);
        }

        if(!array_key_exists('resultPerPage', request()->all())){
            return $country->get();
        }

        return response()->json(
            $country->paginate(request()->query()['resultPerPage'])
        );
    }

    public function getCountryNameByRegion()
    {
        return response()->json(
            Country::select('id', 'region_id', 'name')
                ->where('region_id', request()->query()['region_id'])
                ->whereIsActive(1)
                ->orderBy('name')
                ->get()
        );
    }
}
