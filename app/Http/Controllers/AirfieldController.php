<?php

namespace App\Http\Controllers;

use App\Airfield;
use App\Http\Requests\AirfieldRequest;
use Illuminate\Http\Request;

class AirfieldController extends Controller
{
    public function index()
    {
        $query = Airfield::select();
        return $this->getListForUI($query, request());
    }


    public function create()
    {
        //
    }


    public function store(AirfieldRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Airfield Type has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Airfield::whereId($id)->first();
    }


    public function edit($id)
    {
        return Airfield::whereId($id)->first();
    }

    public function update(AirfieldRequest $request, $id)
    {
        $speciality = $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Airfield Type has been Updated successfully'
            ],
            'redirection'=>'/admin/airport/airfield/'.$speciality->id
        ]);
    }


    public function destroy($id)
    {
        Airfield::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Airfield Type has been deleted successfully'
            ],
            'redirection'=>'/admin/airport/airfield'
        ]);
    }

    public function lists(){
        $airfield = Airfield::select();

        foreach(request()->except(['resultPerPage', 'page']) as $key=>$value){
            $airfield->where($key,  $value);
        }
        return response()->json(

            $airfield->paginate(request()->query()['resultPerPage'])
        );
    }
}
