<?php

namespace App\Http\Controllers;

use App\Aircraft;
use App\Airport;
use App\Apu;
use App\Company;
use App\Contact;
use App\Engine;
use App\Event;
use App\News;
use App\Part;
use App\User;
use App\Wanted;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Case_;

class AdminDashboardController extends Controller
{
   public function index(){
        $allUser=User::count();
        $eligableDate=Carbon::now()->subDay(31);
        $eligableDateYearly=Carbon::now()->subDay(365);
       $lastTwelveMonthDate = Carbon::now()->startOfMonth()->subMonth(11);
       $thisMonth = Carbon::now()->endOfMonth();

        $personalPlanMonthly=User::where('order_id',101)->where('trans_date','>',$eligableDate)->count();
        $personalPlanYearly=User::where('order_id',102)->where('trans_date','>',$eligableDateYearly)->count();
        $corporatePlanMonthly=User::where('order_id',201)->where('trans_date','>',$eligableDate)->count();
        $corporatePlanYearly=User::where('order_id',202)->where('trans_date','>',$eligableDateYearly)->count();
        $freePlan=$allUser-$personalPlanMonthly-$personalPlanYearly-$corporatePlanMonthly-$corporatePlanYearly;
        $pieChartData=[$freePlan,$personalPlanMonthly+$personalPlanYearly,$corporatePlanMonthly+$corporatePlanYearly];

        $lineChartData=DB::table('users')
            ->select(DB::raw("count('ab_users.id') as users"), DB::raw('MONTHNAME(ab_users.created_at) month'))
            ->whereBetween('created_at', [$lastTwelveMonthDate, $thisMonth])
            ->orderBy(DB::raw("month(ab_users.created_at)"))
            ->groupBy('month')
            ->get();

         $activeUser=User::whereIsActive(1)->count();
         $inActiveUser=User::whereIsActive(0)->count();
         $activeCompany=Company::whereIsActive(1)->count();
         $inActiveCompany=Company::whereIsActive(0)->count();
         $activeContact=Contact::whereIsPublished(1)->count();
         $inActiveContact=Contact::whereIsPublished(0)->count();
         $activeAircraft=Aircraft::whereIsActiveByUser(1)->where('isActiveStatus','=','Approved')->count();
         $inActiveAircraft=Aircraft::whereIsActiveByUser(0)->orWhere('isActiveStatus','!=','Approved')->count();
        $activeEngine=Engine::whereIsActiveByUser(1)->where('isActiveStatus','=','Approved')->count();
        $inActiveEngine=Engine::whereIsActiveByUser(0)->orWhere('isActiveStatus','!=','Approved')->count();
        $activeApu=Apu::whereIsActiveByUser(1)->where('isActiveStatus','=','Approved')->count();
        $inActiveApu=Apu::whereIsActiveByUser(0)->orWhere('isActiveStatus','!=','Approved')->count();
       $activeWanted=Wanted::whereIsActive(1)->count();
       $inActiveWanted=Wanted::whereIsActive(0)->count();
       $activePart=Part::whereIsActive(1)->count();
       $inActivePart=Part::whereIsActive(0)->count();
       $activeTotalAsset=$activeAircraft+$activeEngine+$activeApu;
       $inActiveTotalAsset=$inActiveAircraft+$inActiveEngine+$inActiveApu;
       $activeAirport=Airport::whereIsActive(1)->count();
       $inActiveAirport=Airport::whereIsActive(0)->count();
       $activeNews=News::whereIsActive(1)->count();
       $inActiveNews=News::whereIsActive(0)->count();
       $activeEvent=Event::whereIsActive(1)->whereBetween('end_date',[Carbon::today(),
           Carbon::parse('31-12-2080')])->count();
       $inActiveEvent=Event::whereIsActive(0)->whereNotBetween('end_date',[Carbon::today(),
           Carbon::parse('31-12-2080')])->count();




        return response()->json([
            'pieChartData'=>$pieChartData,
            'lineChartData'=>$lineChartData,
            'activeUser'=>$activeUser,
            'inActiveUser'=>$inActiveUser,
            'activeCompany'=>$activeCompany,
            'inActiveCompany'=>$inActiveCompany,
            'activeContact'=>$activeContact,
            'inActiveContact'=>$inActiveContact,
            'activeAircraft'=>$activeAircraft,
            'inActiveAircraft'=>$inActiveAircraft,
            'activeEngine'=>$activeEngine,
            'inActiveEngine'=>$inActiveEngine,
            'activeApu'=>$activeApu,
            'inActiveApu'=>$inActiveApu,
            'activeWanted'=>$activeWanted,
            'inActiveWanted'=>$inActiveWanted,
            'activePart'=>$activePart,
            'inActivePart'=>$inActivePart,
            'activeTotalAsset'=>$activeTotalAsset,
            'inActiveTotalAsset'=>$inActiveTotalAsset,
            'activeAirport'=>$activeAirport,
            'inActiveAirport'=>$inActiveAirport,
            'activeNews'=>$activeNews,
            'inActiveNews'=>$inActiveNews,
            'activeEvent'=>$activeEvent,
            'inActiveEvent'=>$inActiveEvent,
        ]);
   }
}
