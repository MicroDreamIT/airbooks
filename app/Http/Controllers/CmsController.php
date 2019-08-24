<?php

namespace App\Http\Controllers;

use App\Cms;
use App\Http\Requests\CmsRequest;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function index()
    {
        $query = Cms::select();
        return $this->getListForUI($query, request());
    }


    public function create()
    {

    }


    public function store(CmsRequest $request)
    {

        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'CMS has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Cms::with('medias')->whereId($id)->first();
    }


    public function edit($id)
    {
        return response()->json([
            'cms'=>Cms::with('medias')->whereId($id)->first()
        ]);

    }

    public function update(CmsRequest $request, $id)
    {
        $cms=$request->updatePersist($id);
        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Cms has been Updated successfully'
            ],
            'redirection'=>'/admin/cms/'.$cms->id
        ]);
    }


    public function destroy($id)
    {
        Cms::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Cms has been deleted successfully'
            ],
            'redirection'=>'/admin/cms'
        ]);
    }

    public function lists(){

        $cms = Cms::select();
        foreach(request()->except(['resultPerPage', 'page']) as $key=>$value){
            $cms->where($key,  $value);
        }

        return response()->json(
            $cms->paginate(request()->query()['resultPerPage'])
        );
    }

    public function getCmsContentBySecton($pageUrl){

        $query=Cms::with('medias')->whereUrl($pageUrl)->whereIsActive(1)->get();
        return $query;

    }
}
