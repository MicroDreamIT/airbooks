<?php

namespace App\Http\Controllers;

use App\PaymentHistory;
use App\Plan;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentHistoryController extends Controller
{
    public function show(){
       $paymentHistory=PaymentHistory::whereUserId(Auth::id())->whereResponseMessage('Approved')->orderBy('id','DESC')->first();
       return $paymentHistory;
    }

    public function store(){

        $request=request()->all();
        $request=array_merge($request,[
            'user_id'=>auth()->user()->id,
            'trans_date'=>Carbon::parse($request['trans_date'])
        ]);
        PaymentHistory::create($request);
        $user=User::find(Auth::id());
        if($request['response_message']=='Approved'){
            $user->transaction_id=$request['transaction_id'];
           $user->order_id=$request['order_id'];
            $user->trans_date=Carbon::parse($request['trans_date']);
            $user->save();

        }
        return redirect()->to('/user/payment-history');
    }


    public function getPlanDetails(){
        $type=request()->input('type');
        $user=Auth::user();
        $productName=$this->getProductNameAndType($user)[0];
        $productType=$this->getProductNameAndType($user)[1];
        $model='\\App\\'.ucfirst($type);
        $eligableDate=null;
        $plan=null;
        $countData=null;

        $days=Carbon::parse($user->trans_date)->diffInDays(Carbon::now());

        if($productType=='monthly'){
            $eligableDate=Carbon::parse($user->trans_date)->addDay(31);
            if($days<=31){
                $plan=Plan::with('points')->where('name',$productName)->first();
                $countData=$model::where('user_id',$user->id)->where('is_featured',1)->whereBetween('promotion_date',[$user->trans_date,$eligableDate])->count();
            }
        }else{
            $eligableDate=Carbon::parse($user->trans_date)->addDay(365);
            if($days<=365){
                $plan=Plan::with('points')->where('name',$productName)->first();
                $countData=$model::where('user_id',$user->id)->where('is_featured',1)->whereBetween('promotion_date',[$user->trans_date,$eligableDate])->count();
            }
        }





        return response()->json([
            'plan'=>$plan,
            'countData'=>$countData,
        ]);

    }





    public function getProductNameAndType($user){
        $productName='';
        $productType='';
        switch ($user->order_id){
            case 101:
                $productName='personal';
                $productType='monthly';
                break;

            case 102:
                $productName='personal';
                $productType='yearly';
                break;

            case 201:
                $productName='corporate';
                $productType='monthly';
                break;

            case 202:
                $productName='corporate';
                $productType='yearly';
                break;
            default:
        }

        return [$productName,$productType];

    }
}
