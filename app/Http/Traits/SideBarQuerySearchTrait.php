<?php
/**
 * Created by PhpStorm.
 * User: MDIT
 * Date: 27-Nov-18
 * Time: 3:01 PM
 */

namespace App\Http\Traits;


use Illuminate\Support\Facades\DB;

trait SideBarQuerySearchTrait
{
    public function getDataBySearchInfo($query, $modelName=null,$joinTableName=null)
    {


        if($modelName=='news'){
            $modelName='new';
        }

        if (request()->input('category')) {

            $this->requestWithWhere($query, 'category',$joinTableName);

        }
        if (request()->input('manufacturer')) {
            $this->requestWithWhere($query, 'manufacturer',$joinTableName);
        }
        if (request()->input('type')) {
            $this->requestWithWhere($query, 'type',$joinTableName);
        }
        if (request()->input('model')) {
            $this->requestWithWhere($query, 'model',$joinTableName);
        }
        if (request()->input('offer_for')) {
            $query->where(function ($query) use ($joinTableName,$modelName) {
                $modelName=='wanted'?$searchField='terms':$searchField='offer_for';
                foreach (request()->input('offer_for') as $key => $value) {
                    if ($key == 0) {
                        $query->where($joinTableName . '.'.$searchField, $value);
                    } else {
                        $query->orWhere($joinTableName . '.'.$searchField, $value);
                    }
                }

            });
        }


        if (request()->input('status')) {
            $query->where(function ($query) use ($joinTableName) {

                foreach (request()->input('status') as $key => $value) {
                    if ($key == 0) {
                        $query->where($joinTableName . '.status', $value);
                    } else {
                        $query->orWhere($joinTableName . '.status', $value);
                    }
                }

            });
        }

        if(in_array($modelName,['engine','apu'])){

            if(request()->input('cycle_remaining_from')==0 && request()->input('cycle_remaining_to')){
                $from=(int)request()->input('cycle_remaining_from');
                $to=(int)request()->input('cycle_remaining_to');
                $query->whereBetween('cycle_remaining',[$from==0?$from:$from-1,$to==0?$to:$to+1]);
            }
        }
        if (request()->input('country')) {
            if($modelName=='part'){
                $this->requestWithSpecificTable($query, 'country','parts','location');
            }else{
                $this->requestWithWhere($query, 'country',$joinTableName);
            }
        }

        if (request()->input('only_user_based_contact') && $modelName=='contact') {

            $query->where($joinTableName.'.user_id', '!=',null);
        }

        if (request()->input('continent')) {

            $this->requestWithWhere($query, 'continent',$joinTableName);
        }

        if (request()->input('region')) {

            $this->requestWithWhere($query, 'region',$joinTableName);
        }
        if (request()->input('speciality')) {

            $this->requestWithWhere($query, 'speciality',$joinTableName);
        }
        if (request()->input('asset_type')) {

            $this->filterAssetType($query);
        }
        if (request()->input('airfield_type')) {

            $this->requestWithWhere($query, 'airfield_type',$joinTableName);
        }

        if (request()->input('condition')) {

            $this->requestWithWhere($query, 'condition',$joinTableName);
        }

        if (request()->input('company')) {

            $this->requestWithWhere($query, 'company',$joinTableName);
        }

        if (request()->input('job_title')) {

            $query->where(function ($query) use ($joinTableName) {
                foreach (request()->input('job_title') as $key => $value) {
                    if ($key == 0) {
                        $query->where($joinTableName .'.job_title', $value);
                    } else {
                        $query->orWhere($joinTableName . '.job_title', $value);
                    }
                }

            });
        }
        if (request()->input('title')) {


            if($modelName=='contact'){

                $query->where($joinTableName.'.first_name', 'LIKE', '%'.request()->input('title').'%');
                $query->orWhere($joinTableName.'.last_name', 'LIKE', '%'.request()->input('title').'%');

            }else if($modelName=='companie' || $modelName=='airport'){

                $query->where($joinTableName.'.name', 'LIKE','%'.request()->input('title').'%');
            }else{

                $query->where($joinTableName.'.title', 'LIKE','%'.request()->input('title').'%');
            }

        }

        if (request()->input('is_active_by_user')) {
            if(in_array($modelName,['aircraft','engine','apu'])){
                $query->where($joinTableName.'.deleted_at', '=',null);
                $query->where($joinTableName.'.is_active_by_user', request()->input('is_active_by_user'));
            }else{
                if($modelName=='contact'){
                    $query->where($joinTableName.'.is_published', request()->input('is_active_by_user'));
                }else{
                    if(in_array($modelName,['wanted','part','companie'])){
                        $query->where($joinTableName.'.deleted_at', '=',null);
                    }
                    $query->where($joinTableName.'.is_active', request()->input('is_active_by_user'));
                }

            }


        }
        if (request()->input('isActiveStatus')) {
            if(in_array($modelName,['aircraft','engine','apu'])){
                $query->where($joinTableName.'.isActiveStatus', request()->input('isActiveStatus'));
            }


        }
        if (request()->has('partsSearchTitle')) {

            $query->where(function ($query){
                foreach (request()->input('partsSearchTitle') as $key => $value) {
                    if ($key == 0) {
                        $query->where('part_number', 'like',$value.'%')
                            ->orWhere('alternate_part_number', 'like',$value.'%');
                    } else {
                        $query->orWhere('alternate_part_number', 'like',$value.'%')
                            ->orWhere('part_number', $value);
                    }
                }
            });
        }


        return $query;
    }

    /**
     * @param $query
     * @param $joinTableName
     */
    public function requestWithWhere($query,$requestField, $joinTableName)
    {
        if($requestField=='category' && $joinTableName=='news'){
            $joinTableName='category_news';
        }

        if($requestField=='category' && $joinTableName=='events'){
            $joinTableName='category_event';
        }
        if($requestField=='speciality' && $joinTableName=='companies'){
            $joinTableName='company_speciality';
        }

        $query->where(function ($query) use ($joinTableName,$requestField) {

            foreach (request()->input($requestField) as $key => $value) {
                if ($key == 0) {
                    $query->where($joinTableName . '.'.$requestField.'_id', $value);
                } else {
                    $query->orWhere($joinTableName . '.'.$requestField.'_id', $value);
                }
            }

        });
    }

    public function requestWithSpecificTable($query, $requestField,$joinTableName,$fieldName){

        $query->where(function ($query) use ($joinTableName,$requestField,$fieldName) {

            foreach (request()->input($requestField) as $key => $value) {
                if ($key == 0) {
                    $query->where($joinTableName . '.'.$fieldName, $value);
                } else {
                    $query->orWhere($joinTableName . '.'.$fieldName, $value);
                }
            }

        });
    }
}