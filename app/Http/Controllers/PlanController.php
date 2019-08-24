<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanRequest;
use App\Plan;
use App\Point;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $query = Plan::select();
        return $this->getListForUI($query, request());
    }


    public function create()
    {

    }


    public function store(PlanRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Plan has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Plan::with('points')->whereId($id)->first();
    }


    public function edit($id)
    {
        return $this->show($id);
    }

    public function update(PlanRequest $request, $id)
    {
        $plan = $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Plan has been Updated successfully'
            ],
            'redirection'=>'/admin/commercial/plan/'.$plan->id
        ]);
    }


    public function destroy($id)
    {
        Plan::destroy($id);
        $entities = Point::wherePlanId($id)->get();
        $entityIds = $entities->map( function($entity) {
            return [$entity['id']];
        });
        Point::whereIn('id', $entityIds)->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Plan has been deleted successfully'
            ],
            'redirection'=>'/admin/commercial/plan'
        ]);
    }

    public function lists(){

        $plan = Plan::select();
        foreach(request()->except(['resultPerPage','page']) as $key=>$value){
            $plan->where($key,  $value);
        }
        return response()->json(
            $plan->paginate(request()->query()['resultPerPage'])
        );
    }

    public function getPlan(){
        return response()->json([
            "leftPlan"=>Plan::with('points')->wherePosition('Left')->whereIsActive(1)->first(),
            "centerPlan"=>Plan::with('points')->wherePosition('Center')->whereIsActive(1)->first(),
            "rightPlan"=>Plan::with('points')->wherePosition('Right')->whereIsActive(1)->first(),
        ]);
    }
}
