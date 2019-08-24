<?php

namespace App\Http\Controllers;

use App\Continent;
use App\Http\Requests\ContinentRequest;
use Illuminate\Http\Request;

class ContinentController extends Controller
{
    public function index()
    {
        $query = Continent::select();
        return $this->getListForUI($query, request());
    }


    public function create()
    {
        //
    }


    public function store(ContinentRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Continent has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Continent::whereId($id)->first();
    }


    public function edit($id)
    {
        return Continent::whereId($id)->first();
    }

    public function update(ContinentRequest $request, $id)
    {
        $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Continent has been Updated successfully'
            ],
            'redirection'=>'/admin/location/continent'
        ]);
    }


    public function destroy($id)
    {
        Continent::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Continent has been deleted successfully'
            ],
            'redirection'=>'/admin/location/continent'
        ]);
    }

    public function lists(){
        $continent = Continent::select();
        foreach(request()->except(['resultPerPage','page']) as $key=>$value){
            $continent->where($key,  $value);
        }

        return response()->json(
            $continent->paginate(request()->query()['resultPerPage'])
        );
    }
}
