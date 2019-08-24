<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeoCreateRequest;
use App\Seo;
use Illuminate\Http\Request;

class SeoController extends Controller
{

    public function index(Request $request)
    {
        $query=Seo::with('medias')->select();


        return $this->getListForUI($query, $request);
    }


    public function create()
    {
        //
    }


    public function store(SeoCreateRequest $request)
    {
        $request->persist();
        return response()->json([
            'type'=>'success',
            'message'=>'Seo has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Seo::with('medias')->whereId($id)->first();
    }


    public function edit($id)
    {
        return Seo::with('medias')->whereId($id)->first();
    }


    public function update(SeoCreateRequest $request, $id)
    {
        $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Seo has been Updated successfully'
            ],
            'redirection'=>''
        ]);
    }


    public function destroy($id)
    {
        $category=Seo::find($id);
        $category->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Seo has been deleted successfully'
            ],
            'redirection'=>''
        ]);
    }
}
