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

        $urlIndexes = explode('/',strtolower(request()->path()));

        $seo = count($urlIndexes) > 1 ? $this->findMeta($urlIndexes) : Seo::where('url', $urlIndexes[0])->first();

        return view('welcome', ['metaHead' => $seo]);
    }

    /**
     * @param $urlIndexes
     * @return stdClass
     */
    public function findMeta($urlIndexes): stdClass
    {
        $modelName = 'App\\' . title_case($urlIndexes[0]);
        $model = $modelName::where('id', explode('-', $urlIndexes[1]))->first();
        $seo = new StdClass();
        $seo->title = str_replace('-', ' ', $model->title);
        $seo->description = $model->description;
        return $seo;
    }
}
