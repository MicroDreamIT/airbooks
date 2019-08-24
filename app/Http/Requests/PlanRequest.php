<?php

namespace App\Http\Requests;

use App\Freature;
use App\Plan;
use App\Point;
use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique_with:plans, name,ignore:'.$this->route('plan'),
            'title' => 'required',
            'price' => 'required',
            'is_active' => 'required',
        ];
    }

    public function createPersist(){
        $plan=Plan::create($this->except('points'));
            if($this->input('points')){
                foreach ($this->input('points') as $pointDtata){
                    if(!$pointDtata==null){
                        $point=new Point();
                        $point->plan_id=$plan->id;
                        $point->points_type=$pointDtata['points_type']?$pointDtata['points_type']:'';
                        $point->number_points=$pointDtata['number_points']?$pointDtata['number_points']:0;
                        $point->point_text=$pointDtata['point_text']?$pointDtata['point_text']:'';
                        $point->save();
                    }
                }
            }


    }
    public function updatePersist($id)
    {
        $plan=Plan::with('points')->whereId($id)->first();
        Point::wherePlanId($plan->id)->delete();
        $plan->update($this->except('points'));

        if($this->input('points')){
            foreach ($this->input('points') as $pointDtata){
                if(!$pointDtata==null){
                    $point=new Point();
                    $point->plan_id=$plan->id;
                    $point->points_type=$pointDtata['points_type']?$pointDtata['points_type']:'';
                    $point->number_points=$pointDtata['number_points']?$pointDtata['number_points']:0;
                    $point->point_text=$pointDtata['point_text']?$pointDtata['point_text']:'';
                    $point->save();
                }

            }
        }

        return $plan;
    }
}
