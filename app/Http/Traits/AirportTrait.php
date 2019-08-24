<?php
/**
 * Created by PhpStorm.
 * User: MDIT
 * Date: 04-Dec-18
 * Time: 11:00 AM
 */

namespace App\Http\Traits;


use Illuminate\Support\Facades\DB;

trait AirportTrait
{
    public function getAirportBasedOnJoin(){


        $id=auth()->check()?auth()->user()->id:0;
        $query=DB::table('airports')
            ->select('airports.name', 'airports.id','airports.id as aid',
                'airports.iata_code','airports.icao_code', 'airports.is_active',
                'cities.name as city_name', 'countries.name as country_name',
                'airfield_types.name as airfield_name',

                DB::raw("(Select COUNT(CASE WHEN 
                likable_id=aid and likable_type='App\\\Airport' THEN 1 else null end) 
                from ab_likes) as likes"),

                DB::raw("(SELECT IFNULL( (Select CASE WHEN likable_id=aid 
                and likable_type='App\\\Airport' THEN true else false end 
                from ab_likes Where likable_id=aid and likable_type='App\\\Airport' 
                and user_id=$id) ,false)) as hasLike"))

            ->leftJoin('cities', 'airports.city_id','=','cities.id')
            ->leftJoin('airfield_types', 'airports.airfield_type_id','=','airfield_types.id')
            ->leftJoin('states', 'cities.state_id','=','states.id')
            ->leftJoin('countries', 'states.country_id','=','countries.id');

        return $query;
    }
}