<?php

namespace App\Http\Controllers;



use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, CommonControllerMethods;

    public function deleteRelatedActivities($id,$baseModel,$idField,$typeField,$model){
        $ids=[];
        $results=$baseModel::where($idField,$id)->where($typeField,$model)->get();

        foreach ($results as $result){
            $ids[]=$result->id;
        }
        $baseModel::whereIn('id',$ids)->delete();
    }

}
