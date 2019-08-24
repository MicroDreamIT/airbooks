<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReleaseRequest;
use App\Release;
use Illuminate\Http\Request;

class ReleaseController extends Controller
{
    public function index()
    {
        $query = Release::select();
        return $this->getListForUI($query, request());
    }


    public function create()
    {

    }


    public function store(ReleaseRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Release has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Release::whereId($id)->first();
    }


    public function edit($id)
    {
        return Release::whereId($id)->first();
    }

    public function update(ReleaseRequest $request, $id)
    {
        $release = $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Release has been Updated successfully'
            ],
            'redirection'=>'/admin/parts/release/'.$release->id
        ]);
    }


    public function destroy($id)
    {
        Release::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Release has been deleted successfully'
            ],
            'redirection'=>'/admin/parts/release'
        ]);
    }

    public function lists(){

        $release = Release::select();
        foreach(request()->except(['resultPerPage','page']) as $key=>$value){
            $release->where($key,  $value);
        }

        return response()->json(
            $release->paginate(request()->query()['resultPerPage'])
        );
    }
}
