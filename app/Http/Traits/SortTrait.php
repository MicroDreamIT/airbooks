<?php
/**
 * Created by PhpStorm.
 * User: MDIT
 * Date: 02-Jan-19
 * Time: 12:13 PM
 */

namespace App\Http\Traits;


use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

Trait SortTrait
{
    public function getSearchBasedDataFavourite($data)
    {
        $newData=[];
        foreach ($data as $item){

            if(stripos($item->favouritable->title,request()->query('searchValue'))!==FALSE){
                $newData[]=$item;
            }elseif (stripos($item->favouritable->name,request()->query('searchValue'))!==FALSE){
                $newData[]=$item;
            }elseif (stripos($item->favouritable->first_name.' '.$item->favouritable->last_name,request()->query('searchValue'))!==FALSE){
                $newData[]=$item;
            }
        }

        $data=$this->makePaginate($newData);
        return $data;
    }

    public function getSearchBasedDataLead($data)
    {
        $value=request()->query('searchValue');

        $newData=[];
        foreach ($data as $item){
            $title=$this->findTitle($item);
            if(stripos($title,$value)!==FALSE){
                $newData[]=$item;
            }elseif(stripos($item->user->contact->fullName,$value)!==FALSE){
                $newData[]=$item;
            }elseif(stripos($item->user->contact->company->name,$value)!==FALSE){
                $newData[]=$item;
            }elseif(stripos($item->lead_status,$value)!==FALSE){
                $newData[]=$item;
            }
        }

        $data=$this->makePaginate($newData);
        return $data;
    }



    public function getSortDataFavouritable($data)
    {

        $newData=[];
        foreach ($data as $item) {
            if(isset($item->favouritable->name)){
                $item['title']=$item->favouritable->name;
                $newData[]=$item;
            }elseif (isset($item->favouritable->title)){
                $item['title']=$item->favouritable->title;
                $newData[]=$item;
            }elseif (isset($item->favouritable->first_name)){
                $item['title']=$item->favouritable->first_name.' '+$item->favouritable->last_name;
                $newData[]=$item;
            }
        }

        $sort = array();
        foreach($newData as $k=>$v) {
            $sort['title'][$k] = $v['title'];

        }
        $sort=array_map('strtolower', $sort['title']);
        if(request()->input('sortOrder')=='desc'){
            array_multisort($sort, SORT_DESC,$newData);

        }else{
            array_multisort($sort, SORT_ASC,$newData);

        }
        $data=$this->makePaginate($newData);
        return $data;

    }


    public function getSortDataConnection($data)
    {

        $newData=[];
        foreach ($data as $item) {
            $item['first_name']=$item->contact->first_name;
             $newData[]=$item;
        }

        $sort = array();
        foreach($newData as $k=>$v) {
            $sort['first_name'][$k] = $v['first_name'];

        }

        $sort=array_map('strtolower', $sort['first_name']);
        if(request()->input('sortOrder')=='desc'){
            array_multisort($sort, SORT_DESC,$newData);

        }else{
            array_multisort($sort, SORT_ASC,$newData);

        }
        $data=$this->makePaginate($newData);
        return $data;

    }

    public function getSortDataLead($data){
        $newData=[];

        if(request()->input('sortName')=='title'){
            foreach ($data as $item) {
                $item['fieldName']=$this->findTitle($item);
                $newData[]=$item;
            }
        }
        if(request()->input('sortName')=='contact'){
            foreach ($data as $item) {
                $item['fieldName']=$item['user']['contact']['fullName'];
                $newData[]=$item;
            }
        }
        if(request()->input('sortName')=='company'){
            foreach ($data as $item) {
                $item['fieldName']=$item['user']['contact']['company']['name'];
                $newData[]=$item;
            }
        }
        if(request()->input('sortName')=='lead_status'){
            foreach ($data as $item) {
                $item['fieldName']=$item->lead_satus;
                $newData[]=$item;
            }
        }
        if(request()->input('sortName')=='created_at'){
            foreach ($data as $item) {
                $item['fieldName']=$item->created_at;
                $newData[]=$item;
            }
        }



        $sort = array();
        foreach($newData as $k=>$v) {
            $sort['fieldName'][$k] = $v['fieldName'];

        }

        $sort=array_map('strtolower', $sort['fieldName']);


        if(request()->input('sortOrder')=='desc'){
            array_multisort($sort, SORT_DESC,$newData);

        }else{
            array_multisort($sort, SORT_ASC,$newData);

        }



        $data=$this->makePaginate($newData);
        return $data;
    }

    public function makePaginate($query){

        $page = Input::get('page', 1);

        $slice = array_slice($query, request()->input('resultPerPage') * ($page - 1),
            request()->input('resultPerPage'));
        $query = new Paginator($slice, count($query), request()->input('resultPerPage'));

        return $query;
    }

    public function findTitle($item){
        $title=null;
       if(isset($item->leadable->title)){
           if($item->leadable->modelType!='contact'){
               $title=$item->leadable->title;

           }else{
               $title=($item->leadable->first_name.' '.$item->leadable->last_name);
           }
       }elseif(isset($item->leadable->name)){
           $title=$item->leadable->name;

       }
       return $title;
    }

}