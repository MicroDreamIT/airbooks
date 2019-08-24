<?php
/**
 * This file is a part of MicroDreamIT
 * (c) Shahanur Sharif <shahanur.sharif@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * or visit https://microdreamit.com
 * Created by Shahanur Sharif.
 * User: sharif
 * Date: 7/31/2018
 * Time: 2:46 PM
 */

namespace App\Http;


use App\Aircraft;
use App\Airport;
use App\Apu;
use App\Engine;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PaymentHistoryController;
use App\Mail\RFQPartsEmail;
use App\Mail\SendEmailToOwnerFromFrontEnd;
use App\Media;

use App\Part;
use App\Plan;
use App\Wanted;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class GlobalMethods
{

    public function changeBoolean($field, $model, $id)
    {
        $modelName=str_replace('App-', '', $model);
        $model = str_replace('-', '\\', $model)::find($id);

        if($field=='is_featured' && $model->is_featured==false){
            $status=$this->checkPromotDetails($field,$modelName,$model);

            if($status){
                return response()->json([
                'type' => 'success',
                'message' => 'Status has been updated successfully',
            ]);
            }else{
                return response()->json([
                    'type' => 'danger',
                    'message' => 'Sorry you are not eligible for it Please buy plan first',
                ]);
            }


        }else{

            $model->$field = request()->input('status');
            if($field=='is_featured'){
                $model->promotion_date = null;
            }
            $model->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Status has been updated successfully',
            ]);
        }






    }


    public function changeBooleanWithAsset($field, $model, $id)
    {
        $modelName=str_replace('App-', '', $model);
        $model = str_replace('-', '\\', $model)::find($id);
            $model->$field = request()->input('status');
            $model->save();
            Aircraft::whereUserId($model->id)->update(['is_active_by_user'=>request()->input('status')]);
            Engine::whereUserId($model->id)->update(['is_active_by_user'=>request()->input('status')]);
            Apu::whereUserId($model->id)->update(['is_active_by_user'=>request()->input('status')]);
            Part::whereUserId($model->id)->update(['is_active'=>request()->input('status')]);
            Wanted::whereUserId($model->id)->update(['is_active'=>request()->input('status')]);
            return response()->json([
                'type' => 'success',
                'message' => 'Status has been updated successfully',
            ]);

    }

    public function updateImage($model)
    {
        $this->deletePreviousImage($model);

        $this->storeNewImage($model);
    }

    public function promomix()
    {
        $aircraft = Aircraft::with('user.contact.company', 'medias')
            ->where('is_featured', 1)
            ->where('is_active_by_user', 1)
            ->where('isActiveStatus', 'Approved')
            ->inRandomOrder()->take(4)->get()->toArray();

//        apu, engine, aircraft,
        $engine = Engine::with('user.contact.company', 'medias')
            ->where('is_featured', 1)
            ->where('is_active_by_user', 1)
            ->where('isActiveStatus', 'Approved')
            ->inRandomOrder()->take(4)->get()->toArray();

        $apu = Apu::with('user.contact.company', 'medias')
            ->where('is_featured', 1)
            ->where('is_active_by_user', 1)
            ->where('isActiveStatus', 'Approved')
            ->inRandomOrder()->take(4)->get()->toArray();

        $arr = array_merge($aircraft, $engine, $apu);

        return collect($arr)->shuffle();
    }

    private function deletePreviousImage($model)
    {
        $previousImages = $model->medias()->get();

        if (count($previousImages) > 0) {
            foreach ($previousImages as $image) {
                Media::whereId($image->id)->delete();
            }
        }
    }


    private function storeNewImage($model)
    {
        foreach (request()->input('images') as $image) {
            $model->medias()->create([
                'type' => $image['type'],
                'path' => $image['path'],
                'original_file_name' => $image['original_file_name'],
                'is_featured' => array_key_exists('is_featured', $image)? $image['is_featured']: false
            ]);
        }
    }


    public function promomixWithoutFeatured($table, $field, $value)
    {

        $aircraft = Aircraft::with('user.contact.company', 'medias')
            ->where('is_active_by_user', 1)
            ->whereHas($table, function ($query) use ($field, $value) {
                $query->where($field, $value);
            })
            ->where('isActiveStatus', 'Approved')
            ->inRandomOrder()->take(4)->get()->toArray();

//        apu, engine, aircraft,
        $engine = Engine::with('user.contact.company', 'medias')
            ->whereHas($table, function ($query) use ($field, $value) {
                $query->where($field, $value);
            })
            ->where('is_active_by_user', 1)
            ->where('isActiveStatus', 'Approved')
            ->inRandomOrder()->take(4)->get()->toArray();

        $apu = Apu::with('user.contact.company', 'medias')
            ->whereHas($table, function ($query) use ($field, $value) {
                $query->where($field, $value);
            })
            ->where('is_active_by_user', 1)
            ->where('isActiveStatus', 'Approved')
            ->inRandomOrder()->take(4)->get()->toArray();

        $wanted = Wanted::with('user.contact.company')
            ->whereHas($table, function ($query) use ($field, $value) {
                $query->where($field, $value);
            })
            ->where('is_active', 1)
            ->inRandomOrder()->take(4)->get()->toArray();


        $arr = array_merge($aircraft, $engine, $apu, $wanted);

        return collect($arr)->shuffle();
    }

    public function sendMailFromUser()
    {
//        return request()->all();
        if (auth()->check()) {
            if(array_key_exists('id', request()->input('modelData'))){
                $email = request()->input('modelData')['user']['email'];
                (new LeadController())->store();

//            dd(request()->all());

                Mail::to($email)
                    ->send(new SendEmailToOwnerFromFrontEnd(
                        request()->input('modelData'),
                        request()->input('user'),
                        request()->input('message')
                    ));
                return response()->json([
                    'message' => 'Message has been sent successfully',
                    'type' => 'success'
                ]);
            }elseif(!array_key_exists('id', request()->input('modelData')) && count(request()->input('modelData'))>0 ){
                foreach (request()->input('modelData') as $item) {
                    $email = $item['user']['email'];
                    if(!$item['modelType']==="part"){
                        (new LeadController())->store();
                    }
                    Mail::to($email)
                        ->send(new SendEmailToOwnerFromFrontEnd(
                            $item,
                            request()->input('user'),
                            request()->input('message')
                        ));
                }
            }
            return response()->json([
                'message' => 'Message has been sent successfully',
                'type' => 'success'
            ]);
        } else {
            return response()->json([
                'message' => 'Please login to deliver message',
                'type' => 'danger'
            ], 422);
        }

    }


    public function exportData($modelName, $typeName = null)
    {
        $modelPathName = '\\App\\' . ucfirst($modelName);
        $query = $modelPathName::select();

        try {
            if ($typeName) {
                $query->whereType($typeName);
            }
            $query = $query->get();
            return Excel::create($modelName . '_data', function ($excel) use ($query) {
                $excel->sheet('my sheet', function ($sheet) use ($query) {
                    $sheet->fromArray($query);
                });

            })->download('csv');

        } catch (\Exception $e) {
            return back()->with(['type' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    public function importData($modelName)
    {


        $modelPathName = '\\App\\' . ucfirst($modelName);
        try {
            if (request()->hasFile('file')) {
                $file = request()->file('file');
                $path = $file->getPathName();
                $data = Excel::load($path, function ($reader) {
                })->get();
                $joinModelArray = ['manufacturer', 'news', 'event', 'company'];
                foreach ($data as $item) {
                    $item = $item->toArray();
                    if (in_array($modelName, $joinModelArray)) {

                        $this->idsAndExceptFiled($item, $modelPathName, $modelName);

                    } else {
                        $modelPathName::forceCreate(array_except($item, ['id']));
                    }

                }
                return back();
            }
        } catch (\Exception $e) {
            return back()->with(['type' => 'danger', 'message' => $e->getMessage()]);
        }

    }


    public function exportDataWithPivot($modelName, $typeName = null)
    {
        list($tableName, $query) = $this->getJoinData($modelName);

        if ($typeName) {
            $query->where($tableName . '.type', '=', $typeName);
        }
        $query = $query->get();
        $query = json_decode(json_encode($query), true);
        return Excel::create($modelName . '_data', function ($excel) use ($query) {

            $excel->sheet('my sheet', function ($sheet) use ($query) {
                $sheet->fromArray($query);
            });

        })->download('csv');
    }


    /**
     * @param $modelName
     * @return array
     */
    public function getJoinData($modelName)
    {
        $tableName = $modelName . 's';
        $foreginKey = 'category_id';
        if ($modelName == 'manufacturer') {
            $pivotTable = 'category_manufacturer';
        } elseif ($modelName == 'news') {
            $tableName = $modelName;
            $pivotTable = 'category_news';
        } elseif ($modelName == 'event') {
            $pivotTable = 'category_event';
        } elseif ($modelName == 'company') {
            $pivotTable = 'company_speciality';
            $foreginKey = 'speciality_id';
        }

        $query = DB::table($tableName)
            ->select($tableName . '.*')
            ->selectRaw("GROUP_CONCAT(ab_" . $pivotTable . "." . $foreginKey . " SEPARATOR ', ') as " . $foreginKey . "")
            ->leftJoin($pivotTable, $tableName . '.id', '=', $pivotTable . '.' . $modelName . '_id')
            ->groupBy($tableName . '.id');
        return array($tableName, $query);
    }

    /**
     * @param $item
     * @param $modelPathName
     * @param $modelName
     * @return void
     */
    public function idsAndExceptFiled($item, $modelPathName, $modelName)
    {
        $filedName = 'category_id';
        if ($modelName == 'company') {
            $filedName = 'speciality_id';
        }
        $ids = explode(', ', $item[$filedName]);
        $data = $modelPathName::create(array_except($item, [$filedName]));
        if (!$ids[0] == '') {
            $data->categories()->sync($ids);
        }

    }

    public function assetUrlGenerator($asset)
    {
        return '/'.$asset->modelType.'/'.$asset->linkify;
    }




    public function checkPromotDetails($field,$modelName,$model){
        $user=Auth::user();
        $payment= new PaymentHistoryController();
        $productName=$payment->getProductNameAndType($user)[0];
        $productType=$payment->getProductNameAndType($user)[1];
        $days=Carbon::parse($user->trans_date)->diffInDays(Carbon::now());
        $plan=Plan::with('points')->where('name',$productName)->first();

        $points=0;

        if($plan['points']){
            foreach ($plan->points as $item){
                if($item->points_type==strtolower($modelName)){
                    $points=$item->number_points;
                }
            }
        }

        $status=true;
        if($productType=='monthly'){
            $eligableDate=Carbon::parse($user->trans_date)->addDay(31);
            $countData=$model::where('user_id',$user->id)->where('is_featured',1)
                ->whereBetween('promotion_date',[$user->trans_date,$eligableDate])->count();
            if($days<=31 && $countData<$points){
                $model->$field = request()->input('status');
                $model->promotion_date = Carbon::now();
                $model->save();
                $status=true;
            }else{
                $status=false;
            }
        }else{
            $eligableDate=Carbon::parse($user->trans_date)->addDay(365);
            $countData=$model::where('user_id',$user->id)->where('is_featured',1)
                ->whereBetween('promotion_date',[$user->trans_date,$eligableDate])->count();

            if($days<=365 && $countData<$points){
                $model->$field = request()->input('status');
                $model->promotion_date = Carbon::now();
                $model->save();
                $status=true;
            }else{
                $status=false;
            }
        }
        return $status;
    }

    public function sendMailFromUserForParts()
    {
        $datas = [];
        foreach (request()->input('modelData') as $data){
            if(array_key_exists('company', $data['user']['contact'])){
                if($data['contact']['company']['rfq_email']){
                    $datas[$data['contact']['company']['rfq_email']][] = $data;
                }
            }
        }
        foreach ($datas as $key=>$value){
            Mail::to($key)
                ->send(new RFQPartsEmail(request()->input('message'), $value));
        }

        return response()->json([
            'message' => 'Message has been sent successfully',
            'type' => 'success'
        ]);
    }
}

//$data=Excel::load($path)->noHeading()->all()->toArray();
