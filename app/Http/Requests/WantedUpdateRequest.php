<?php

namespace App\Http\Requests;

use App\Wanted;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class WantedUpdateRequest extends FormRequest
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
            'type'=>'required',
            'terms'=>'required',
            'primary_contact'=>'required',
        ];
    }
    public function updatePersist($id){
//        $this->merge(['custom'=>json_encode($this->input('custom'))]);

        $type=$this->input(['type']);
        if($this->input($type.'Model') && $type!='parts'){
            $this->merge(['title'=>str_replace(' ', '-',$this->input($type.'Manufacturer')['name']) .'-' . str_replace(' ','-',$this->input($type.'Type')['name']).'-'. str_replace(' ','-',$this->input($type.'Model')['name']) .'-wanted-for-'. $this->input('terms')]);
        }else{
            if($type=='parts'){
                $this->merge(['title'=>str_replace(' ', '-',$this->input('part_number')).'-wanted-for-'. $this->input('terms')]);

            }else{
                $this->merge(['title'=>str_replace(' ', '-',$this->input($type.'Manufacturer')['name']) .'-' . str_replace(' ','-',$this->input($type.'Type')['name']).'-wanted-for-'. $this->input('terms')]);
            }

        }
        $this->merge(['wanted_by' => Carbon::parse($this->input('wanted_by'))]);


        $wanted=Wanted::whereId($id)->first();
        $wanted->fill($this->all());
        $wanted->user()->associate(auth()->id());
        $wanted->manufacturer()->associate($this->input($this->input('type').'Manufacturer')['id']);
        $wanted->typed()->associate($this->input($this->input('type').'Type')['id']);
        $wanted->modeled()->associate($this->input($this->input('type').'Model')['id']);
        $wanted->contact()->associate($this->input('primary_contact')['id']);
        $wanted->country()->associate($this->input('country')['id']);
        $wanted->update();
    }
}
