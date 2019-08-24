<?php

namespace App\Http\Controllers;

use App\Condition;
use App\Continent;
use App\Http\Requests\ConditionRequest;
use Illuminate\Http\Request;

class ConditionController extends Controller
{
    public function index()
    {
        $query = Condition::select();
        return $this->getListForUI($query, request());
    }


    public function create()
    {

    }


    public function store(ConditionRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Condition has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Condition::whereId($id)->first();
    }


    public function edit($id)
    {
        return Condition::whereId($id)->first();
    }

    public function update(ConditionRequest $request, $id)
    {
        $condition = $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Condition has been Updated successfully'
            ],
            'redirection'=>'/admin/parts/condition/'.$condition->id
        ]);
    }


    public function destroy($id)
    {
        Condition::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Condition has been deleted successfully'
            ],
            'redirection'=>'/admin/parts/condition'
        ]);
    }

    public function lists(){

        $condition = Condition::select();
        foreach(request()->except(['resultPerPage','page']) as $key=>$value){
            $condition->where($key,  $value);
        }

        return response()->json(
            $condition->paginate(request()->query()['resultPerPage'])
        );
    }
}
