<?php
/**
 * Created by PhpStorm.
 * User: MDIT
 * Date: 05-Dec-18
 * Time: 11:52 AM
 */

namespace App\Http\Traits;


use Illuminate\Support\Facades\DB;

trait CompanyTrait
{
    public function getCompanyDataBasedOnJoin(){
        $id=auth()->check()?auth()->user()->id:0;
        $query=DB::table('companies')
            ->select('companies.name', 'companies.id','companies.id as cid', 'countries.name as country_name','companies.is_active',
                DB::raw("(Select COUNT(CASE WHEN likable_id=cid and likable_type='App\\\Company' THEN 1 else null end) from ab_likes) as likes"),
                DB::raw("(SELECT IFNULL( (Select CASE WHEN likable_id=cid and likable_type='App\\\Company' THEN true else false end from ab_likes Where likable_id=cid and likable_type='App\\\Company' and user_id=$id) ,false)) as hasLike"),
                DB::raw("(Select path from ab_medias where mediable_type='App\\\Company' and mediable_id=cid) as path"),
                DB::raw("(Select original_file_name from ab_medias where mediable_type='App\\\Company' and mediable_id=cid) as original_file_name"),
                DB::raw("(Select COUNT(*) from ab_contacts where company_id=cid) as contactCount"))
            ->selectRaw("GROUP_CONCAT(ab_specialities.name SEPARATOR ', ') as speciality_name")
            ->leftJoin('company_speciality', 'companies.id','=','company_speciality.company_id')
            ->leftJoin('specialities', 'company_speciality.speciality_id','=','specialities.id')
            ->leftJoin('countries', 'companies.country_id','=','countries.id');
        return $query;
    }

    public function getCompanySidebarData($baseTableName, $modelName, $foreignKey){

            $modelName ='companie';
            $baseTableName == 'specialities' ? $tableName = 'company_speciality' : $tableName = $modelName . 's';
            $query = DB::table('companies')
                ->select($baseTableName . '.id', $baseTableName . '.name',DB::raw("count(ab_companies.id) as itemCount"));

            if($baseTableName=='specialities'){
                $query->join('company_speciality', 'companies.id', '=', 'company_speciality.company_id')
                    ->join('specialities', 'company_speciality.speciality_id', '=', 'specialities.id');
            }
            if($baseTableName=='countries'){
                $query->join('countries', 'companies.country_id', '=', 'countries.id');
            }
            $query->groupBy($baseTableName.'.id');

            if(request()->input('speciality')){
                if($baseTableName!='specialities'){
                    $query->join('company_speciality', 'companies.id', '=', 'company_speciality.company_id')
                        ->join('specialities', 'company_speciality.speciality_id', '=', 'specialities.id');
                }

                $this->getDataBySearchInfo($query,$modelName,$modelName.'s');
            }else{
                $this->getDataBySearchInfo($query,$modelName,$modelName.'s');
            }

            $query=$query->get();
            return $query;

    }
}