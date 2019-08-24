<?php

namespace App\Http\Requests;

use App\Apu;
use App\Http\Controllers\AttachController;
use App\Http\GlobalMethods;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ApuUpdateRequest extends FormRequest
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
//            'esn' => 'required|min:3|unique_with:engines, name,ignore:'.$this->route('engine'),
            'category'=>'required',
            'manufacturer'=>'required',
            'type'=>'required',
            'status'=>'required',
            'serial_number'=>'required',
            'primary_contact'=>'required',
            'offer_for'=>'required',
            'availability'=>'required',
        ];
    }

    public function updatePersist($id){
//        dd($this->input('availability'));

        if($this->input('model')){
            $this->merge(['title'=>str_replace(' ', '-',$this->input('manufacturer')['name']) .'-' . str_replace(' ','-',$this->input('type')['name']).'-'. str_replace(' ','',$this->input('model')['name']) .'-available-for-'. $this->input('offer_for')]);
        }else{
            $this->merge(['title'=>str_replace(' ', '-',$this->input('manufacturer')['name']) .'-' . str_replace(' ','-',$this->input('type')['name']).'-available-for-'. $this->input('offer_for')]);
        }

        $this->merge(['availability'=>Carbon::createFromFormat('d-m-Y',$this->input('availability'))->toDateTimeString()]);

        $needIsActiveStatusChange=false;

        $apu=Apu::whereId($id)->first();

        if($apu->sn != $this->input('sn')){
            $needIsActiveStatusChange=true;
        }
        $apu->fill($this->all());
        if($needIsActiveStatusChange){
            $apu->isActiveStatus='Pending Approval';
        }

        $apu->user()->associate(auth()->id());
        $apu->category()->associate($this->input('category')['id']);
        $apu->manufacturer()->associate($this->input('manufacturer')['id']);
        $apu->type()->associate($this->input('type')['id']);
        $apu->model()->associate($this->input('model')['id']);
        $apu->contact()->associate($this->input('primary_contact')['id']);
        $apu->currentLocation()->associate($this->input('current_location')['id']);
      $thrust_rating=$lsv_description=null;
        if($this->input('custom')){
            foreach ($this->input('custom') as $custom){
                $custom['name']=='thrust_rating'?$thrust_rating=$custom['value']:null;
                $custom['name']=='lsv_description'?$lsv_description=$custom['value']:null;
            }
        }
        $apu->thrust_rating=$thrust_rating;
        $apu->lsv_description=$lsv_description;

        $owner=$seller=null;
        if($this->input('custom2')) {
            foreach ($this->input('custom2') as $custom) {
                $custom['name']=='owner'?$owner=$custom['value']['id']:null;
                $custom['name']=='seller'?$seller=$custom['value']['id']:null;
            }
        }
        $apu->owner()->associate($owner);
        $apu->seller()->associate($seller);
        $apu->save();


	    if(count($this->input('images'))>0){
		    //delete previous image
		    (new GlobalMethods())->updateImage($apu);
		
	    }

        (new AttachController())->uploadFile($apu);


        return $apu;
    }
}
