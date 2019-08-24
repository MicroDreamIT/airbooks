<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use App\Contact;
use App\Continent;
use App\Country;
use App\Event;
use App\Favourite;
use App\Http\Requests\EventRequest;
use App\Http\Traits\EventTrait;
use App\Http\Traits\NewsTrait;
use App\Http\Traits\searchTrait;
use App\Region;
use App\State;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    use EventTrait,searchTrait;
    public $tableName = 'events';

    public function index()
    {
        $query=$this->getEventBasedOnJoinData();
        if(request()->query('searchValue')){
            $this->inputSearch($query);
        }
        if(request()->query('is_active')){
            $query->where('events.is_active','=',request()->query('is_active'));
        }
        if(request()->query('date_over')){
            $query->whereBetween('events.end_date',[Carbon::today(),
                Carbon::parse(request()->query('date_over'))]);
        }


        return $this->getListForUIJoin($query,'events.id');
    }



    public function create()
    {
       return response()->json([
           'continents'=>Continent::whereIsActive(1)->get(),
           'categories'=>Category::whereType('event')->whereIsActive(1)->get(),

       ]);
    }


    public function store(EventRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Event has been created successfully'
        ]);
    }


    public function show($id)
    {
        $event = Event::with(['contact', 'city','state','country.medias', 'categories', 'medias', 'continent', 'region'])->whereId($id)->first();

        $event->update([
            'views'=>$event->views + 1
        ]);

        return $event;
    }


    public function edit($id)
    {
        $event=Event::whereId($id)->first();
        return response()->json([
            'event'=> Event::with(['contact', 'city','state','country','categories', 'medias','continent', 'region'])->whereId($id)->first(),
            'continents'=>Continent::whereIsActive(1)->get(),
            'regions'=>Region::whereContinentId($event->continent_id)->get(),
            'country'=>Country::whereRegionId($event->region_id)->get(),
            'state'=>State::whereCountryId($event->country_id)->get(),
            'cities'=>City::whereStateId($event->state_id)->get(),
            'categories'=>Category::whereType('event')->whereIsActive(1)->get(),
            'visitors'=>Contact::whereIsPublished(1)->get(),
        ]);
    }

    public function update(EventRequest $request, $id)
    {
        $event = $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Event has been Updated successfully'
            ],
            'redirection'=>'/admin/event/'.$event->id
        ]);
    }


    public function destroy($id)
    {

        $this->deleteRelatedActivities($id,
            '\\App\\Like','likable_id','likable_type','App\\Event');
        $this->deleteRelatedActivities($id,
            '\\App\\Favourite','favouritable_id','favouritable_type','App\\Event');
        $this->deleteRelatedActivities($id,
            '\\App\\View','viewable_id','viewable_type','App\\Event');

        $event = Event::with('categories')->whereId($id)->first();
        $categoryIds=[];
        foreach ($event->categories as $category){
            $categoryIds[]=$category['id'];
        }
        $event->categories()->sync($categoryIds);
        $event->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Event has been deleted successfully'
            ],
            'redirection'=>'/admin/event'
        ]);
    }

    public function lists(){

        $event = Event::select();
            foreach(request()->except(['resultPerPage','page']) as $key=>$value){
                $event->where($key,  $value);
            }

        return response()->json(
            $event->paginate(request()->query()['resultPerPage'])
        );
    }

    public function getSearchData(){

        $query=$this->getEventBasedOnJoinData();

        $query->groupBy('events.id');
        
        $query->whereBetween('events.end_date',[Carbon::today(),
            Carbon::parse('31-12-2080')]);

        if (request()->input('is_active_by_user')) {
            $query->where('events.is_active', request()->input('is_active_by_user'));
        }

        if (request()->input('category')) {
            $this->filterCategoriesForJoinData($query,'category_event');
        }
        if (request()->input('region')) {
            $this->filterRegion($query,'events');
        }
        if (request()->input('country')) {
            $this->filterCountry($query,'events');
        }


        return $query->paginate(20);
    }


    public function getInterestedData($event_id){
        $data= User::with('contact.company','contact.jobTitle','favourites')
            ->whereHas('favourites',function ($query)use($event_id){
            $query->where('favouritable_id',$event_id);
            $query->where('favouritable_type','App\\Event');
        })->take(2)->get();
        return $data;

    }
}
