<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecialityRequest;
use App\Speciality;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{

    public function index()
    {
        $query = Speciality::select();
        return $this->getListForUI($query, request());
    }


    public function create()
    {
        //
    }


    public function store(SpecialityRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Speciality has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Speciality::whereId($id)->first();
    }


    public function edit($id)
    {
        return Speciality::whereId($id)->first();
    }

    public function update(SpecialityRequest $request, $id)
    {
        $speciality = $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Speciality has been Updated successfully'
            ],
            'redirection'=>'/admin/company/speciality/'.$speciality->id
        ]);
    }


    public function destroy($id)
    {
        Speciality::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Speciality has been deleted successfully'
            ],
            'redirection'=>'/admin/company/speciality'
        ]);
    }

    public function lists(){
        $speciality = Speciality::select();
        foreach(request()->except(['resultPerPage','page']) as $key=>$value){
            $speciality->where($key,  $value);
        }

        return response()->json(
            $speciality->paginate(request()->query()['resultPerPage'])
        );
    }
}
