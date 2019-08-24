<?php
/**
 * This file is a part of MicroDreamIT
 * (c) Shahanur Sharif <shahanur.sharif@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * or visit https://microdreamit.com
 * Created by Shahanur Sharif.
 * User: sharif
 * Date: 11/17/2018
 * Time: 1:53 PM
 */

namespace App\Http;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChartData
{

    /**
     * ChartData constructor.
     */
    public function __construct()
    {
    }

    public function getChart()
    {

        $lastTenMonthDate = Carbon::now()->startOfMonth()->subMonth(9);
        $thisMonth = Carbon::now()->endOfMonth();

        $modelPath = 'App\\' . request()->input('model');

        $tableName = strtolower(request()->input('model')).'s';

        $modelId = request()->input('id');

        list($likes, $favourite) = $this->like_and_favourite_by_id($modelId, $tableName, $lastTenMonthDate, $thisMonth);


        $getTypeData = $this->like_and_favourite_by_type($tableName, $modelId, $lastTenMonthDate, $thisMonth);


         return ['id'=>$this->getChartData($likes, $favourite), 'type'=>$this->getChartData($getTypeData[0], $getTypeData[1])];

    }
    private function getChartData($likes, $favourite)
    {
        $label=[];
        $likeData = [];
        $favouriteData = [];

        foreach ($likes as $key=>$value){
            $label[]=$key;
        }

        foreach ($favourite as $key=>$value){
            array_push($label, $key);
        }

        $monthName = [];
        $label = array_unique($label);

        $label = array_sort($label);


        foreach ($label as $item){
            $monthName [] = date('F', mktime(0,0,0,$item, 1));
        }

        $likeData = $this->getDataSet($likes, $label, $likeData);

        $favouriteData = $this->getDataSet($favourite, $label, $favouriteData);

        return ['label'=>$monthName, 'likes'=>$likeData, 'views'=>$favouriteData];
    }

    /**
     * @param $likes
     * @param $label
     * @param $likeData
     * @return mixed
     */
    private function getDataSet($likes, $label, $likeData)
    {
        $label = array_unique($label);

        foreach ($label as $month) { //9, 10, 11
            if (array_key_exists($month, json_decode(json_encode($likes), TRUE))) {
                $likeData[$month] = $likes[$month];
            } else {
                $likeData[$month] = 0;
            }
        }

        $newValue=[];
        foreach ($likeData as $keys=>$newLike){
            $newValue[] = $newLike;
        }

        return $newValue;
    }

    /**
     * @param $modelId
     * @param $tableName
     * @param $lastTenMonthDate
     * @param $thisMonth
     * @return array
     */
    private function like_and_favourite_by_id($modelId, $tableName, $lastTenMonthDate, $thisMonth)
    {
        $data = DB::table('likes')
            ->select(DB::raw("count('id') as likes"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month')
            )
            ->where('likable_id', '=', $modelId)
            ->where('likable_type', '=', 'App\\' . request()->input('model'))
            ->whereBetween('created_at', [$lastTenMonthDate, $thisMonth])
            ->groupBy( 'month');

        $likes = $data->pluck('likes', 'month');


        $data = DB::table('views')
            ->select(DB::raw("count('id') as view"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month')
            )
            ->where('viewable_id', '=', $modelId)
            ->where('viewable_type', '=', 'App\\' . request()->input('model'))
            ->whereBetween('created_at', [$lastTenMonthDate, $thisMonth])
            ->groupBy( 'month');

        $favourites = $data->pluck('view', 'month');

        return array($likes, $favourites);
    }

    /**
     * @param $modelPath
     * @param $modelId
     * @param $lastTenMonthDate
     * @param $thisMonth
     * @return mixed
     */
    private function like_and_favourite_by_type($modelPath, $modelId, $lastTenMonthDate, $thisMonth)
    {
        $className = 'App\\' . request()->input('model');
        $modelObject = $className::whereId($modelId)->first();
        $type_id = $modelObject->type_id;
        $model_id = $modelObject->model_id;
        $manufacturer_id = $modelObject->manufacturer_id;




        $likes= DB::table($modelPath)
            ->select(DB::raw("count('ab_likes.id') as likes"),
                DB::raw('MONTH(ab_likes.created_at) month')
            )
            ->leftJoin('likes',$modelPath.'.id','=','likes.likable_id')
            ->where('likes.likable_type','=','App\\' . request()->input('model'))
            ->where($modelPath.'.type_id','=',$type_id)
            ->where($modelPath.'.model_id','=',$model_id)
            ->where($modelPath.'.manufacturer_id','=',$manufacturer_id)
            ->whereBetween('likes.created_at', [$lastTenMonthDate, $thisMonth])
            ->groupBy('month');
        $likes = $likes->pluck('likes', 'month');

        $favourite= DB::table($modelPath)
            ->select(DB::raw("count('ab_views.id') as view"),
                DB::raw('MONTH(ab_views.created_at) month')
            )
            ->leftJoin('views',$modelPath.'.id','=','views.viewable_id')
            ->where('views.viewable_type','=','App\\' . request()->input('model'))
            ->where($modelPath.'.type_id','=',$type_id)
            ->where($modelPath.'.model_id','=',$model_id)
            ->where($modelPath.'.manufacturer_id','=',$manufacturer_id)
            ->whereBetween('views.created_at', [$lastTenMonthDate, $thisMonth])
            ->groupBy('month');

        $favourite = $favourite->pluck('view', 'month');
        return [$likes, $favourite];
    }

}