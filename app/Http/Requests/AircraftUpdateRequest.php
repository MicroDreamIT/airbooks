<?php

namespace App\Http\Requests;

use App\Aircraft;
use App\Http\Controllers\AttachController;
use App\Http\GlobalMethods;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class AircraftUpdateRequest extends FormRequest
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
            'category'=>'required',
            'aircraftManufacturer'=>'required',
            'aircraftType'=>'required',
            'MSN'=>'required',
            'YOM'=>'required',
            'offer_for'=>'required',
            'primary_contact'=>'required',
            'availability'=>'required',
        ];
    }
    public function updatePersist($id)
    {
        $needIsActiveStatusChange=false;

        $aircraft=Aircraft::whereId($id)->first();

        if($aircraft->MSN != $this->input('MSN')){
            $needIsActiveStatusChange=true;
        }
        $aircraft->fill($this->all());

        if($needIsActiveStatusChange){
            $aircraft->isActiveStatus='Pending Approval';
        }


        $aircraft->user()->associate(auth()->id());
        $aircraft->category()->associate($this->input('category')['id']);
        $aircraft->manufacturer()->associate($this->input('aircraftManufacturer')['id']);
        $aircraft->type()->associate($this->input('aircraftType')['id']);
        $aircraft->modeled()->associate($this->input('aircraftModel')['id']);
        $aircraft->engineManufacturer()->associate($this->input('engineManufacturer')['id']);
        $aircraft->engineType()->associate($this->input('engineType')['id']);
        $aircraft->engineModel()->associate($this->input('engineModel')['id']);
        $owner=$seller=$manager=$previous_operator=$current_operator=null;

        if($this->input('custom2')){
            foreach ($this->input('custom2') as $custom){
                $custom['name']=='owner'?$owner=$custom['value']['id']:null;
                $custom['name']=='current_operator'?$current_operator=$custom['value']['id']:null;
                $custom['name']=='previous_operator'?$previous_operator=$custom['value']['id']:null;
                $custom['name']=='manager'?$manager=$custom['value']['id']:null;
                $custom['name']=='seller'?$seller=$custom['value']['id']:null;
            }
        }

        $aircraft->owner()->associate($owner);
        $aircraft->seller()->associate($seller);
        $aircraft->manager()->associate($manager);
        $aircraft->currentOperator()->associate($current_operator);
        $aircraft->previousOperator()->associate($previous_operator);


        $tsn=$csn=$mtow=$mlgw=$last_c_check=$registration_number=null;$compliance='Values';

        if($this->input('custom')){
            foreach ($this->input('custom') as $custom){
                $custom['name']=='registration_number'?$registration_number=$custom['value']:null;
                $custom['name']=='registration_country'?$aircraft->registeredIn()->associate($custom['value']['id']):$aircraft->registeredIn()->associate(null);
                $custom['name']=='tsn'?$tsn=$custom['value']:null;
                $custom['name']=='csn'?$csn=$custom['value']:null;
                $custom['name']=='mtow'?$mtow=$custom['value']:null;
                $custom['name']=='mlgw'?$mlgw=$custom['value']:null;
                $custom['name']=='last_c_check'?$last_c_check=Carbon::parse($custom['value']):null;
                $custom['name']=='compliance'?$compliance=$custom['value']:null;
            }
        }

        $aircraft->tsn=$tsn;
        $aircraft->csn=$csn;
        $aircraft->mlgw=$mlgw;
        $aircraft->mtow=$mtow;
        $aircraft->last_c_check=$last_c_check;
        $aircraft->compliance=$compliance;
        $aircraft->registration_number=$registration_number;

        $aircraft->configuration()->associate($this->input('configuration')['id']);

        $aircraft->currentLocation()->associate($this->input('current_location')['id']);

        $aircraft->primaryContact()->associate($this->input('primary_contact')['id']);
        $aircraft->YOM = Carbon::createFromFormat('d/m/Y', '01/01/'.$this->input('YOM'));
//        dd($aircraft, $this->input('YOM'));
        $aircraft->availability = Carbon::createFromFormat('d-m-Y',$this->input('availability'))->toDateTimeString();

        if($this->input('aircraftModel')){
            $aircraft->title = str_replace(' ', '-',$this->input('aircraftManufacturer')['name']) .'-'.str_replace(' ', '-',$this->input('aircraftType')['name']) .'-'. str_replace(' ','-',$this->input('aircraftModel')['name']) .'-available-for-'. $this->input('offer_for').'-YOM-'.$this->input('YOM');
        }else{
            $aircraft->title = str_replace(' ', '-',$this->input('aircraftManufacturer')['name']) .'-'.str_replace(' ', '-',$this->input('aircraftType')['name']) .'-available-for-'. $this->input('offer_for').'-YOM-'.$this->input('YOM');
        }
        $aircraft->update();



	    if(count($this->input('images'))>0){
		    //delete previous image
		    (new GlobalMethods())->updateImage($aircraft);
		
	    }

        $attachClass = new AttachController();

        $attachClass->uploadFile($aircraft);

        return $aircraft;
    }

}
