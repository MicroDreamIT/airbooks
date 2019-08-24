<?php
/**
 * Created by PhpStorm.
 * User: MDIT
 * Date: 25-Nov-18
 * Time: 11:24 AM
 */

namespace App\Http\Traits;

use App\News;
use Illuminate\Support\Facades\DB;
trait SideBarSearchTrait
{
    use NewsTrait,EventTrait,SideBarQuerySearchTrait,CompanyTrait;
    public function getDataByModel($baseTableName, $modelName, $foreignKey)
    {
        $expectionalData = ['news', 'event'];
        if (in_array($modelName, $expectionalData) ) {
            if($modelName=='news'){
                $query = $this->getNewsSidebarData($baseTableName, $modelName, $foreignKey);
            }else{
                $query = $this->getEventSidebarData($baseTableName, $modelName, $foreignKey);
            }
        } elseif($modelName=='company') {

            $query = $this->getCompanySidebarData($baseTableName, $modelName, $foreignKey);

        }else{

            $modelName=='company'?$modelName='companie':null;
            $modelName=='part' && $baseTableName=='countries'?$foreignKey='location':null;

            $query = DB::table($baseTableName)
                ->join($modelName.'s',$modelName.'s.'.$foreignKey, '=',$baseTableName.'.id')
                ->select($baseTableName.'.id', $baseTableName.'.name',DB::raw("count(ab_".$modelName."s.".$foreignKey.") as itemCount"))
                ->groupBy($modelName.'s.'.$foreignKey);

            $this->getDataBySearchInfo($query,$modelName,$modelName.'s');

            $query=$query->get();
        }
        return $query;
    }






    public function getOfferForAndStatus($modelName)
    {
        $status = [];
        $modelName == 'wanted' ? $filedName = 'terms' : $filedName = 'offer_for';
        $query = DB::table($modelName . 's')->select($filedName,DB::raw("count(id) as itemCount"));
        $query = $this->getDataBySearchInfo($query, $modelName,$modelName.'s');
        $offeredFor = $query->groupBy($filedName)->get();

        if ($modelName != 'wanted') {
            $status = DB::table($modelName . 's')->select('status',DB::raw("count(id) as itemCount"));
            $status = $this->getDataBySearchInfo($status, $modelName,$modelName.'s');
            $status = $status->groupBy('status')->get();
        }
        return array($query, $offeredFor, $status);
    }



    public function getYom($modelName)
    {
        $yomFrom = 0;
        $yomTo = 0;
        $query = DB::table($modelName . 's')->select();
        $query = $this->getDataBySearchInfo($query, $modelName,$modelName.'s');
        $query = $query->orderBy('YOM', 'ASC')->groupBy('YOM')->first();

        if ($query) {
            $yomFrom = (int)substr($query->YOM, 0, 4);
        }

        $query = DB::table($modelName . 's')->select();
        $query = $this->getDataBySearchInfo($query,$modelName,$modelName.'s');
        $query = $query->groupBy('YOM')->orderBy('YOM', 'DESC')->first();

        if ($query) {
            $yomTo = (int)substr($query->YOM, 0, 4);
        }
        return array($query, $yomFrom, $yomTo);
    }


    public function getCycleRemaning($modelName)
    {
        $cycleRemaning = 0;
        $query = DB::table($modelName . 's')->select();
        $query = $this->getDataBySearchInfo($query, $modelName,$modelName.'s');

        $query = $query->orderBy('cycle_remaining', 'DESC')->groupBy('cycle_remaining')->first();
        if ($query) {
            $cycleRemaning = $query->cycle_remaining;
        }

        return array($query, $cycleRemaning);
    }


}