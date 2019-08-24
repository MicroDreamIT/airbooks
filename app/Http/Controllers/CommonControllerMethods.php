<?php
/**
 * This file is a part of MicroDreamIT
 * (c) Shahanur Sharif <shahanur.sharif@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * or visit https://microdreamit.com
 * Created by Shahanur Sharif.
 * User: sharif
 * Date: 1/5/2019
 * Time: 4:10 PM
 */

namespace App\Http\Controllers;
use App\Http\GlobalMethods;
use App\Http\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait CommonControllerMethods
{

    /**
     * @param $model
     * @param $id
     * @param $columnName
     * @return mixed
     */
    public function columnUpdate($model, $id, $columnName)
    {
        $valueType = ['Approved', 'Pending Approval', 'Rejected'];
        $model = '\App\\'.title_case($model);
//        dd($model, $id, $columnName, request()->input('value'));

        $asset = $model::with('user')->where('id', (integer) $id)->first();
        if(!in_array(request()->input('value'), $valueType)){
            // revise mail
            $url = 'user'.(new GlobalMethods())->assetUrlGenerator($asset);
            $email = $asset->user->email;
            $name =  $asset->user->contact['fullName'];
            $subject = 'please revise your asset';
            $content = request()->input('value');
            $asset->update(['status_reason'=>request()->input('value')]);
            (new SendMail())->assetReviseEmail($email, $subject, $content, $url, $name);
//            (new SendMail())->generic($email, $subject, $content, $url, $name);
        }else{

            (new SendMail())->cannedEmail($asset->user->email, $asset->user->contact->fullName, url((new GlobalMethods())->assetUrlGenerator($asset)), 'asset-status', request()->input('value'));
        }

        $asset->update([$columnName=>!in_array(request()->input('value'), $valueType)?'Revise':request()->input('value')]);

        return response()->json(['Done']);

    }


    public function getListForUI($query, Request $request)
    {
        $data = null;
        if(request()->query('searchValue')){
            if(strpos(url()->current(),'contact') !==false){
                $value=request()->query('searchValue');

                $query->whereRaw("concat(first_name, ' ', last_name) like '%$value%' ");
                $query->orWhereHas('company', function($q) use ($value) {
                    $q->where('name', 'LIKE', "%$value%");

                    if(array_key_exists('creator_id', request()->query())){
                        $q->where('creator_id', request()->input('creator_id'));
                    }
                });
                $query->orWhereHas('jobTitle', function($q) use ($value) {
                    $q->where('name', 'LIKE', "%$value%");

                    if(array_key_exists('creator_id', request()->query())){
                        $q->where('creator_id', request()->input('creator_id'));
                    }
                });

                if(request()->input('email')){
                    $query->orWhere(function ($query) use ($value){
                        $query->where('email', 'LIKE', "%$value%");
                        if(array_key_exists('creator_id', request()->query())){
                            $query->where('creator_id', request()->input('creator_id'));
                        }
                    });

                }
            }else{
                $this->inputSearch($query);
            }
        }

        if(request()->has('dropDownSearch')){
            $arr = json_decode( request()->input('dropDownSearch') ) ;

            foreach ($arr as $value){
                if($value->selected){
                    $query->where($value->column, $value->selected);
                }
            }
        }

        if ($request->input('paging')) {

            if($request->input('sortName')=='companies.name'){
                $query->leftJoin('companies','companies.id','=','contacts.company_id');
                $query->select('contacts.*','companies.name');
                $data=$query->orderBy('companies.name', $request->input('sortOrder'))
                    ->paginate($request->input('resultPerPage'));

            }else{
                $data = $query->orderBy($request->input('sortName'), $request->input('sortOrder'))->paginate($request->input('resultPerPage'));
            }


        } else {
            $data = $query->orderBy($request->input('sortName'), $request->input('sortOrder'))->get();
        }

        return response()->json($data);
    }

    public function joinData($tableOne, $tableTwo, $foreginKey){

        return DB::table($tableOne)
            ->join($tableTwo,$tableOne.'.'.$foreginKey, '=', $tableTwo.'.id')
            ->select($tableTwo.'.name as '.$tableTwo.'_name', $tableOne.'.*');

    }

    public function getListForUIJoin($query, $groupBy=null)
    {
        if($groupBy){
            $query->groupBy($groupBy);
        }
        $query->orderBy($this->checkNested(request()->query('sortName')), request()->query('sortOrder'));
        if (request()->input('paging')) {
            $data = $query->paginate(request()->input('resultPerPage'));
        } else {
            $data = $query->get();
        }


        return response()->json($data);
    }

    public function checkNested($query)
    {
        if(strpos($query, '.')){
            return $query; //types.name
        }else{
            return $this->tableName.'.'.$query;
        }
    }

    public function inputSearch($query,$type=null)
    {

        $keys = explode(',', request()->query('searchKey'));
        foreach ($keys as $index => $value) {
            if (!$index) {
                $query->where($value, 'LIKE','%'.request()->input('searchValue').'%');
            } else {
                $query->orWhere($value, 'LIKE','%'.request()->input('searchValue').'%');
                if(request()->query('type')){
                    $query->where($type,request()->query('type'));
                }
            }
        }
    }

    private function viewCreate()
    {


    }

}