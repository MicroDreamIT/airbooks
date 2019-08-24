<?php

namespace App\Http\Controllers;

use App\Http\Requests\TitleRequest;
use App\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function index()
    {
        $query = Title::select();
        return $this->getListForUI($query, request());
    }


    public function create()
    {
        //
    }


    public function store(TitleRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Title has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Title::whereId($id)->first();
    }


    public function edit($id)
    {
        return Title::whereId($id)->first();
    }

    public function update(TitleRequest $request, $id)
    {
        $title = $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Title has been Updated successfully'
            ],
            'redirection'=>'/admin/company/title/'.$title->id
        ]);
    }


    public function destroy($id)
    {
        Title::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Title has been deleted successfully'
            ],
            'redirection'=>'/admin/company/title'
        ]);
    }

    public function lists(){
        $title = Title::select();
        foreach(request()->except(['resultPerPage','page']) as $key=>$value){
            $title->where($key,  $value);
        }

        return response()->json(
            $title->paginate(request()->query()['resultPerPage'])
        );
    }
}
