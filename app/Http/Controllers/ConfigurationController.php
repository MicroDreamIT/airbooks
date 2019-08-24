<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Http\Requests\ConfigurationRequest;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $query = Configuration::select();
        return $this->getListForUI($query, request());
    }


    public function create()
    {

    }


    public function store(ConfigurationRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Configuration has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Configuration::whereId($id)->first();
    }


    public function edit($id)
    {
        return Configuration::whereId($id)->first();
    }

    public function update(ConfigurationRequest $request, $id)
    {
        $release = $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Configuration has been Updated successfully'
            ],
            'redirection'=>'/admin/aircraft/configuration/'.$release->id
        ]);
    }


    public function destroy($id)
    {
        Configuration::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Configuration has been deleted successfully'
            ],
            'redirection'=>'/admin/aircraft/configuration'
        ]);
    }

    public function lists(){

        $configuration = Configuration::select();
        foreach(request()->except(['resultPerPage','page']) as $key=>$value){
            $configuration->where($key,  $value);
        }

        return response()->json(
            $configuration->paginate(request()->query()['resultPerPage'])
        );
    }
}
