<?php
/**
 * Created by PhpStorm.
 * User: MDIT
 * Date: 25-Oct-18
 * Time: 4:28 PM
 */

namespace App\Http\Traits;


use Illuminate\Support\Facades\DB;

trait NewsTrait
{
    protected function getNewsDataBasedOnJoin(){
        $id=auth()->check()?auth()->user()->id:0;
        $query=DB::table('news')
            ->select('news.title', 'news.id','news.id as nid', 'news.is_active', 'news.date','categories.name as category_name',
                DB::raw("(Select COUNT(CASE WHEN likable_id=nid and likable_type='App\\\News' THEN 1 else null end) from ab_likes) as likes"),
                DB::raw("(Select path from ab_medias where mediable_type='App\\\News' and mediable_id=nid) as path"),
                DB::raw("(SELECT IFNULL( (Select CASE WHEN likable_id=nid and likable_type='App\\\News' THEN true else false end from ab_likes Where likable_id=nid and likable_type='App\\\News' and user_id=$id) ,false)) as hasLike"),
                DB::raw("(Select original_file_name from ab_medias where mediable_type='App\\\News' and mediable_id=nid) as original_file_name"),'companies.name as company_name','regions.name as region_name')
            ->leftJoin('companies', 'news.company_id','=','companies.id')
            ->leftJoin('regions', 'regions.id','=','news.region_id')
            ->leftJoin('category_news', 'category_news.news_id','=','news.id')
            ->leftJoin('categories','category_news.category_id','=','categories.id');
        return $query;

    }


    public function getNewsSidebarData($baseTableName, $modelName, $foreignKey)
    {

        $modelName == 'news' ? $modelName = 'new' : null;
        $baseTableName == 'categories' ? $tableName = 'category_news' : $tableName = $modelName . 's';
        $query = DB::table('news')
            ->select($baseTableName . '.id', $baseTableName . '.name',DB::raw("count(ab_news.id) as itemCount"));
        if($baseTableName=='categories'){
            $query->leftJoin('category_news', 'news.id', '=', 'category_news.news_id')
                ->leftJoin('categories', 'category_news.category_id', '=', 'categories.id');
        }
        if($baseTableName=='countries'){
            $query->leftJoin('countries', 'news.country_id', '=', 'countries.id');
        }
        if($baseTableName=='regions'){
            $query ->leftJoin('regions', 'news.region_id', '=', 'regions.id');
        }
        if($baseTableName=='continents'){
            $query ->leftJoin('continents', 'news.continent_id', '=', 'continents.id');
        }
        $query->groupBy($baseTableName.'.id');

        if(request()->input('category')){
            if($baseTableName!='categories'){
                $query->leftJoin('category_news', 'news.id', '=', 'category_news.news_id')
                    ->leftJoin('categories', 'category_news.category_id', '=', 'categories.id');
            }

            $this->getDataBySearchInfo($query,$modelName,$modelName.'s');
        }else{
            $this->getDataBySearchInfo($query,$modelName,$modelName.'s');
        }

        $query=$query->get();


        return $query;
    }
}