<?php

namespace App\Http\Controllers;

use App\Aircraft;
use App\Apu;
use App\Engine;
use App\Part;
use App\Wanted;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserDashboardController extends Controller
{
    public function index(){
        $userId=Auth::id();
        $aircraftActive=Aircraft::whereUserId($userId)->whereIsActiveByUser(1)
            ->where('isActiveStatus','Approved')->count();
        $aircraftInactive=Aircraft::whereUserId($userId)->where('isActiveStatus','!=','Approved')->count();
        $engineActive=Engine::whereUserId($userId)->whereIsActiveByUser(1)
            ->where('isActiveStatus','Approved')->count();
        $engineInactive=Engine::whereUserId($userId)->where('isActiveStatus','!=','Approved')->count();
        $apuActive=Apu::whereUserId($userId)->whereIsActiveByUser(1)
            ->where('isActiveStatus','Approved')->count();
        $apuInactive=Apu::whereUserId($userId)->where('isActiveStatus','!=','Approved')->count();
        $wantedActive=Wanted::whereUserId($userId)->whereIsActive(1)->count();
        $wantedInactive=Wanted::whereUserId($userId)->whereIsActive(0)->count();

        $aircraftLeads=Aircraft::join('leads','leads.leadable_id','=','aircrafts.id')
            ->where('aircrafts.user_id',$userId)
            ->where('leads.leadable_type','App\\Aircraft')
            ->count('leads.id');
        $engineLeads=Engine::join('leads','leads.leadable_id','=','engines.id')
            ->where('engines.user_id',$userId)
            ->where('leads.leadable_type','App\\Engine')
            ->count('leads.id');

        $apuLeads=Apu::join('leads','leads.leadable_id','=','apus.id')
            ->where('apus.user_id',$userId)
            ->where('leads.leadable_type','App\\Apu')
            ->count('leads.id');

        $wantedLeads=Wanted::join('leads','leads.leadable_id','=','wanteds.id')
            ->where('wanteds.user_id',$userId)
            ->where('leads.leadable_type','App\\Wanted')
            ->count('leads.id');


        $chartData=[$aircraftLeads,$engineLeads,$apuLeads,$wantedLeads];

        $airViewsData=$this->getViewsCount('aircrafts','App\\Aircraft');
        $engViewsData=$this->getViewsCount('engines','App\\Engine');
        $apuViewsData=$this->getViewsCount('apus','App\\Apu');
        $wantedViewsData=$this->getViewsCount('wanteds','App\\Wanted');


        return response()->json([
           'aircraftActive'=>$aircraftActive,
           'aircraftInactive'=>$aircraftInactive,
           'engineActive'=>$engineActive,
           'engineInactive'=>$engineInactive,
           'apuActive'=>$apuActive,
           'apuInactive'=>$apuInactive,
            'wantedActive'=>$wantedActive,
            'wantedInactive'=>$wantedInactive,
            'chartData'=>$chartData,
            'airViewsData'=>$airViewsData,
            'engViewsData'=>$engViewsData,
            'apuViewsData'=>$apuViewsData,
            'wantedViewsData'=>$wantedViewsData,

        ]);

    }

    private function getViewsCount($tableName,$modelName)
    {
        $userId=Auth::id();
        $mainModel='\\'.$modelName;
        $viewsCountData=$mainModel::join('views','views.viewable_id','=',$tableName.'.id')
            ->where($tableName.'.user_id',$userId)
            ->where('views.viewable_type',$modelName)
            ->whereDate('views.created_at', '>', Carbon::now()->subDays(30))
            ->selectRaw('count(IFNULL(ab_views.id,0)) as count')
            ->groupBy(DB::raw('DAY(ab_views.created_at)'))->get();
        $viewsCount=[];
        foreach ($viewsCountData as $item){
            $viewsCount[]=$item->count;
        }
        return $viewsCount;
    }

}
