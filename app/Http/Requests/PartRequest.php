<?php

namespace App\Http\Requests;

use App\Part;
use Illuminate\Foundation\Http\FormRequest;

class PartRequest extends FormRequest
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
            'part_number' => 'required',
            'condition'=>'required',
            'quantity'=>'required',
            'primary_contact'=>'required',
        ];
    }

    public function createPersist(){
        $title = Part::latest()->first();

        if (!$title) {
            $uid = 'ABP0'.'1';
        }else{
            $uid = 'ABP0'. ($title->id + 1);
        }
        $this->merge(['uid'=>$uid]);
//        $this->merge(['custom'=>json_encode($this->input('custom'))]);

            $this->merge(['title'=>str_replace(' ', '-',$this->input('part_number')) .'-' . str_replace(' ','',$this->input('condition')['name']).'-'.'-available-for-Sale']);


        $part=new Part();
        $part->fill($this->all());
        $part->user()->associate(auth()->id());
        $part->contact()->associate($this->input('primary_contact')['id']);
        $part->condition()->associate($this->input('condition')['id']);
        $part->currentLocation()->associate($this->input('location')['id']);
        if($this->input('custom')){
            foreach ($this->input('custom') as $custom){
                $custom['name']=='release'? $part->release_id=$custom['value']['id']:null;
                $custom['name']=='owner'?$part->owner =$custom['value']['id']:null;
                $custom['name']=='seller'?$part->seller =$custom['value']['id']:null;
                $custom['name']=='price'?$part->price =$custom['value']:null;
                $custom['name']=='location'?$part->location =$custom['value']['id']:null;
                $custom['name']=='unit_measure'?$part->unit_measure=$custom['value']:null;
            }
        }
        $part->save();
    }
}
