<?php

namespace App\Http\Controllers;

use App\Seo;
use Illuminate\Http\Request;
use stdClass;

class SingleAppController extends Controller
{
    public $listModel = [
        'Aircraft', 'Engine', 'Apu', 'Parts', 'Wanted', 'News', 'Events', 'Contact', 'Company', 'Airport'
    ];

    public function index()
    {
//        dd(request()->path());
//        dd("hello");
        $urlIndexes = explode('/',strtolower(request()->path()));
//        dd($urlIndexes);
        $seo = count($urlIndexes) > 1 ? $this->findMeta($urlIndexes) : Seo::where('url', $urlIndexes[0])->first();
//        dd($seo);
        return view('welcome', ['metaHead' => $seo]);
    }

    public function findMeta($urlIndexes)
    {
        if($urlIndexes[0] && $urlIndexes[1]){
            $modelName = 'App\\' . title_case($urlIndexes[0]);
            $model = $modelName::where('id', explode('-', $urlIndexes[1]))->first();
            $seo = new StdClass();
            $seo->title = str_replace('-', ' ', $model->title);
            $seo->description = $this->meta_description($urlIndexes[0], $model);
//            $seo->medias = $this->findImage($seo->medias);
        }else{
            $seo = Seo::where('url', '/')->first();
        }

        return $seo;
    }

    private function findImage($medias)
    {
    }

    private function meta_description($modelName, $model)
    {
        if($modelName==='wanted'){
         return $model->comments;
        }
        if($modelName === 'news'){
            return $model->details;
        }
        if($modelName === 'event'){
            return $model->details;
        }

        return $model->description;
    }
}
