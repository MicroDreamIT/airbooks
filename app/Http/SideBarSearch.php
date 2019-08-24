<?php
/**
 * Created by PhpStorm.
 * User: MDIT
 * Date: 22-Nov-18
 * Time: 3:27 PM
 */

namespace App\Http;


use App\Category;
use App\Http\Traits\searchTrait;
use App\Http\Traits\SideBarSearchTrait;
use App\Manufacturer;
use Illuminate\Support\Facades\DB;

class SideBarSearch
{
    use searchTrait,SideBarSearchTrait;
    public function getSideBarList($modelName)
    {
        $category = [];
        $manufacturer = [];
        $type = [];
        $model = [];
        $status = [];
        $offeredFor = [];
        $country = [];
        $region = [];
        $continent = [];
        $assetType=[];
        $airField=[];
        $yomFrom = 0;
        $yomTo = 0;
        $cycleRemaning = 0;
        $jobTitle=[];
        $speciality=[];
        $condition=[];
        $company=[];

        if($modelName=='parts'){
            $modelName='part';
        }


        if (in_array($modelName, ['aircraft', 'engine', 'apu', 'news', 'event'])) {
            $category = $this->getDataByModel('categories', $modelName, 'category_id');
        }
        if (in_array($modelName, ['aircraft', 'engine', 'apu'])) {
            $manufacturer = $this->getDataByModel('manufacturers', $modelName, 'manufacturer_id');
            $type = $this->getDataByModel('types', $modelName, 'type_id');
            $model = $this->getDataByModel('models', $modelName, 'model_id');
        }
        if (in_array($modelName, ['aircraft', 'engine', 'apu', 'wanted'])) {
            list($query, $offeredFor, $status) = $this->getOfferForAndStatus($modelName);

        }

        if ($modelName == 'aircraft') {
            list($query, $yomFrom, $yomTo) = $this->getYom($modelName);

        }

        if ($modelName == 'engine' ||$modelName == 'apu') {
            list($query, $cycleRemaning) = $this->getCycleRemaning($modelName);
        }

        if (in_array($modelName, ['news', 'event','contact','company','part','airport','wanted'])) {
            $country = $this->getDataByModel('countries', $modelName, 'country_id');

        }
        if (in_array($modelName, ['news', 'event'])) {
            $region = $this->getDataByModel('regions', $modelName, 'region_id');
            $continent = $this->getDataByModel('continents', $modelName, 'continent_id');
        }

        if (in_array($modelName, ['wanted'])) {

            $query = DB::table($modelName . 's')->select('type',DB::raw("count(ab_".$modelName."s.id) as itemCount"));
            $query = $this->getDataBySearchInfo($query,$modelName,$modelName.'s');
            $assetType =$query->groupBy('type')->get();
        }
        if($modelName=='airport'){
            $airField = $this->getDataByModel('airfield_types', $modelName, 'airfield_type_id');
        }
        if($modelName=='contact'){
            $jobTitle = $this->getDataByModel('titles', $modelName, 'job_title');
            $company = $this->getDataByModel('companies', $modelName, 'company_id');
        }
        if($modelName=='company'){
            $speciality = $this->getDataByModel('specialities', $modelName, 'speciality_id');
        }
        if($modelName=='part'){
            $condition = $this->getDataByModel('conditions', $modelName, 'condition_id');
        }

        return response()->json([
            'categories' => $category,
            'manufacturers' => $manufacturer,
            'types' => $type,
            'models' => $model,
            'offeredFor' => $offeredFor,
            'status' => $status,
            'yomFrom' => $yomFrom,
            'yomTo' => $yomTo,
            'cycleRemaning' => $cycleRemaning,
            'country' => $country,
            'region' => $region,
            'assetType' => $assetType,
            'continent' => $continent,
            'airField' => $airField,
            'jobTitle' => $jobTitle,
            'speciality' => $speciality,
            'condition' => $condition,
            'company' => $company,

        ]);
    }




}