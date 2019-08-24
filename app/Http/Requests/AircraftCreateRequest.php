<?php

namespace App\Http\Requests;

use App\Aircraft;
use App\Http\Controllers\AttachController;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class AircraftCreateRequest extends FormRequest
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

    public function persist()
    {
        $lastId = Aircraft::latest()->first();

        if (!$lastId) {
            $uid = 'ABA'.'01';
        }else{
            $uid = 'ABA'. ($lastId->id + 1);
        }
        $this->merge(['availability'=>Carbon::createFromFormat('d-m-Y',$this->input('availability'))->toDateTimeString()]);
        if($this->is_featured){
            $this->merge(['promotion_date'=>Carbon::now()]);
        }

        $aircraft=new Aircraft($this->all());
        $aircraft->user()->associate(auth()->id());
        $aircraft->category()->associate($this->input('category')['id']);
        $aircraft->manufacturer()->associate($this->input('aircraftManufacturer')['id']);
        $aircraft->type()->associate($this->input('aircraftType')['id']);
        $aircraft->modeled()->associate($this->input('aircraftModel')['id']);
        $aircraft->engineManufacturer()->associate($this->input('engineManufacturer')['id']);
        $aircraft->engineType()->associate($this->input('engineType')['id']);
        $aircraft->engineModel()->associate($this->input('engineModel')['id']);
        foreach ($this->input('custom2') as $custom){
            $custom['name']=='owner'?$aircraft->owner()->associate($custom['value']['id']):null;
            $custom['name']=='current_operator'?$aircraft->currentOperator()->associate($custom['value']['id']):null;
            $custom['name']=='previous_operator'?$aircraft->previousOperator()->associate($custom['value']['id']):null;
            $custom['name']=='manager'?$aircraft->manager()->associate($custom['value']['id']):null;
            $custom['name']=='seller'?$aircraft->seller()->associate($custom['value']['id']):null;
        }

        foreach ($this->input('custom') as $custom){
            $custom['name']=='registration_number'?$aircraft->registration_number=$custom['value']:null;
            $custom['name']=='registration_country'?$aircraft->registeredIn()->associate($custom['value']['id']):null;
            $custom['name']=='tsn'?$aircraft->tsn=$custom['value']:null;
            $custom['name']=='csn'?$aircraft->csn=$custom['value']:null;
            $custom['name']=='mtow'?$aircraft->mtow=$custom['value']:null;
            $custom['name']=='mlgw'?$aircraft->mlgw=$custom['value']:null;
            $custom['name']=='last_c_check'?$aircraft->last_c_check=Carbon::parse($custom['value']):null;
            $custom['name']=='compliance'?$aircraft->compliance=$custom['value']:null;
        }

        $aircraft->configuration()->associate($this->input('configuration')['id']);

        $aircraft->currentLocation()->associate($this->input('current_location')['id']);

        $aircraft->primaryContact()->associate($this->input('primary_contact')['id']);

        $aircraft->YOM = Carbon::parse($this->input('YOM'));
        $aircraft->availability = Carbon::parse($this->input('availability'));

        if($this->input('aircraftModel')){
            $aircraft->title = str_replace(' ', '-',$this->input('aircraftManufacturer')['name']) .'-'.str_replace(' ', '-',$this->input('aircraftType')['name']) .'-'. str_replace(' ','-',$this->input('aircraftModel')['name']) .'-available-for-'. $this->input('offer_for').'-YOM-'.Carbon::parse($this->input('YOM'))->year;
        }else{
            $aircraft->title = str_replace(' ', '-',$this->input('aircraftManufacturer')['name']) .'-'.str_replace(' ', '-',$this->input('aircraftType')['name']) .'-available-for-'. $this->input('offer_for').'-YOM-'.Carbon::parse($this->input('YOM'))->year;
        }

        $aircraft->uid = $uid;
        $aircraft->save();

        if(count($this->input('images'))>0){
            foreach ($this->input('images') as $image){
                $aircraft->medias()->create([
                    'type'=>$image['type'],
                    'path'=>$image['path'],
                    'original_file_name'=>$image['original_file_name'],
                    'is_featured'=>array_key_exists('is_featured', $image)? $image['is_featured']: false
                ]);
            }
        }

        $attachClass = new AttachController();

        $attachClass->createFile($aircraft);

        return $aircraft;
    }



    private function uploadContent($aircraft, $files)
    {
        foreach ($files as $file){
            $modelName = 'aircraft';
            $path = auth()->id().'/attaches/'.$modelName.'/' .$aircraft->id;
            $aircraft->attaches()->create([
                'original_file_name'=>$file['upload']['filename'],
                'path'=>$path
            ]);
            Storage::disk('public')->putFile($path, $file);
        }
    }
}
