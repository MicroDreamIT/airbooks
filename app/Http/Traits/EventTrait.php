<?php
/**
 * Created by PhpStorm.
 * User: MDIT
 * Date: 25-Oct-18
 * Time: 4:32 PM
 */

namespace App\Http\Traits;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait EventTrait
{

    protected function getEventBasedOnJoinData(){
        $id=auth()->check()?auth()->user()->id:0;
        $query=DB::table('events')
            ->select('events.title', 'events.id','events.id as eid','events.start_date','events.end_date',
                DB::raw("(Select COUNT(CASE WHEN likable_id=eid and likable_type='App\\\Event' THEN 1 else null end) from ab_likes) as likes"),
                DB::raw("(SELECT IFNULL( (Select CASE WHEN likable_id=eid and likable_type='App\\\Event' THEN true else false end from ab_likes Where likable_id=eid and likable_type='App\\\Event' and user_id=$id) ,false)) as hasLike"),

                DB::raw("(SELECT IFNULL( (Select CASE WHEN favouritable_id=eid and favouritable_type='App\\\Event' THEN true else false end from ab_favourites Where favouritable_id=eid and favouritable_type='App\\\Event' and user_id=$id) ,false)) as hasInterested"),
                DB::raw("(Select path from ab_medias where mediable_type='App\\\Event' and mediable_id=eid) as path"),
                DB::raw("(Select original_file_name from ab_medias where mediable_type='App\\\Event' and mediable_id=eid) as original_file_name"),'events.is_active','countries.name')
            ->selectRaw("GROUP_CONCAT(ab_categories.name SEPARATOR ', ') as category_name")
            ->leftJoin('category_event', 'events.id','=','category_event.event_id')
            ->leftJoin('categories', 'category_event.category_id','=','categories.id')
            ->leftJoin('countries','countries.id','=','events.country_id');
        return $query;
    }







    public function getEventSidebarData($baseTableName, $modelName, $foreignKey)
    {
        $baseTableName == 'categories' ? $tableName = 'category_event' : $tableName = $modelName . 's';

        $query = DB::table('events')
            ->select($baseTableName . '.id', $baseTableName . '.name',DB::raw("count(ab_events.id) as itemCount"))->whereBetween('events.end_date',[Carbon::today(),
                Carbon::parse('31-12-2080')]);
        if($baseTableName=='categories'){
            $query->leftJoin('category_event', 'events.id', '=', 'category_event.event_id')
                ->leftJoin('categories', 'category_event.category_id', '=', 'categories.id');
        }
        if($baseTableName=='countries'){
            $query->leftJoin('countries', 'events.country_id', '=', 'countries.id');
        }
        if($baseTableName=='regions'){
            $query ->leftJoin('regions', 'events.region_id', '=', 'regions.id');
        }
        if($baseTableName=='continents'){
            $query ->leftJoin('continents', 'events.continent_id', '=', 'continents.id');
        }

        $query->groupBy($baseTableName.'.id');

        if(request()->input('category')){
            if($baseTableName!='categories'){
                $query->leftJoin('category_event', 'events.id', '=', 'category_event.event_id')
                    ->leftJoin('categories', 'category_event.category_id', '=', 'categories.id');
            }

            $this->getDataBySearchInfo($query,$modelName,$modelName.'s');
        }else{
            $this->getDataBySearchInfo($query,$modelName,$modelName.'s');
        }


        $query=$query->get();


        return $query;
    }

}