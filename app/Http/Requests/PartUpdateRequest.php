<?php

namespace App\Http\Requests;

use App\Part;
use Illuminate\Foundation\Http\FormRequest;

class PartUpdateRequest extends FormRequest
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

    public function updatePersist($id){
        $this->merge(['title'=>str_replace(' ', '-',$this->input('part_number')) .'-' . str_replace(' ','',$this->input('condition')['name']).'-'.'-available-for-Sale']);
        $part=Part::whereId($id)->first();
        $part->fill($this->all());
        $part->user()->associate(auth()->id());
        $part->contact()->associate($this->input('primary_contact')['id']);
        $part->condition()->associate($this->input('condition')['id']);
        $part->currentLocation()->associate($this->input('location')['id']);
        $release=$location=$owner=$seller=$price=$unitMeasure=null;
        if($this->input('custom')){
            foreach ($this->input('custom') as $custom){
                $custom['name']=='release'? $release=$custom['value']['id']:null;
                $custom['name']=='owner'?$owner=$custom['value']['id']:null;
                $custom['name']=='seller'?$seller =$custom['value']['id']:null;
                $custom['name']=='price'?$price =$custom['value']:null;
                $custom['name']=='location'?$location =$custom['value']['id']:null;
                $custom['name']=='unit_measure'?$unitMeasure=$custom['value']:null;
            }
        }
        $part->release_id=$release;
        $part->location=$location;
        $part->owner=$owner;
        $part->seller=$seller;
        $part->price=$price;
        $part->unit_measure=$unitMeasure;
        $part->save();
    }
}
