<?php

namespace App\Http\Controllers;

use App\Category;
use App\Company;
use App\Continent;
use App\Country;
use App\Http\Requests\NewsRequest;
use App\Http\Traits\NewsTrait;
use App\Http\Traits\searchTrait;
use App\News;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    use NewsTrait,searchTrait;
    public $tableName='news';

    public function index()
    {
        $query=$this->getNewsDataBasedOnJoin();

        if(request()->query('searchValue')){
            $this->inputSearch($query);
        }
        if(request()->query('is_active')){
           $query->where('news.is_active','=',request()->query('is_active'));
        }
        return $this->getListForUIJoin($query,'news.id');
    }


    public function create()
    {
        return response()->json([
            'categories'=> Category::whereType('news')->whereIsActive(1)->get(),
            'companies'=> Company::whereIsActive(1)->get(),
            'continents'=> Continent::whereIsActive(1)->get(),
        ]);
    }


    public function store(NewsRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'News has been created successfully'
        ]);
    }


    public function show($id)
    {
        $news = News::with(['categories','company.specialities','continent', 'region','country','medias'])->whereId($id)->first();

        $news->update([
            'views'=>$news->views + 1
        ]);

//        $news->views()->create();

        return $news;
    }


    public function edit($id)
    {   $news=News::whereId($id)->first();
        return response()->json([
            'news'=>News::with(['categories','company','continent', 'region','country', 'medias'])->whereId($id)->first(),
            'categories'=> Category::whereType('news')->whereIsActive(1)->get(),
            'companies'=> Company::whereIsActive(1)->get(),
            'continents'=> Continent::whereIsActive(1)->get(),
            'regions'=> Region::whereContinentId($news->continent_id)->whereIsActive(1)->get(),
            'countries'=> Country::whereRegionId($news->region_id)->whereIsActive(1)->get()
        ]);

    }

    public function update(NewsRequest $request, $id)
    {
        $news = $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'News has been Updated successfully'
            ],
            'redirection'=>'/admin/news/'.$news->id
        ]);
    }


    public function destroy($id)
    {

        $this->deleteRelatedActivities($id,
            '\\App\\Like','likable_id','likable_type','App\\News');

        $this->deleteRelatedActivities($id,
            '\\App\\View','viewable_id','viewable_type','App\\News');

        $news = News::with('categories')->whereId($id)->first();
        $categoryIds=[];
        foreach ($news->categories as $category){
            $categoryIds[]=$category['id'];
        }
        $news->categories()->sync($categoryIds);
        $news->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'News has been deleted successfully'
            ],
            'redirection'=>'/admin/news'
        ]);
    }

    public function lists(){
        $news = News::select();


            foreach(request()->except(['resultPerPage','page']) as $key=>$value){
                $news->where($key,  $value);
            }

        return response()->json(
            $news->paginate(request()->query()['resultPerPage'])
        );
    }
    public function getSearchData(){
        $query=$this->getNewsDataBasedOnJoin();
        $query->groupBy('news.id');
        if (request()->input('is_active_by_user')) {
            $query->where('news.is_active', request()->input('is_active_by_user'));
        }

        if (request()->input('category')) {
           $this->filterCategoriesForJoinData($query,'category_news');
        }
        if (request()->input('region')) {
            $this->filterRegion($query,'news');
        }
        if (request()->input('country')) {
            $this->filterCountry($query,'news');
        }
        return $query->paginate(20);
    }


}
