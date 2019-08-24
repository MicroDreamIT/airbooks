<?php

namespace App\Http\Requests;

use App\Apu;
use App\Http\Controllers\AttachController;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ApuRequest extends FormRequest
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

    public function createPersist(){
        $title = Apu::latest()->first();

        if (!$title) {
            $uid = 'ABAP'.'01';
        }else{
            $uid = 'ABAP'. ($title->id + 1);
        }
        $this->merge(['uid'=>$uid]);

        if($this->is_featured){
            $this->merge(['promotion_date'=>Carbon::now()]);
        }

        if($this->input('model')){
            $this->merge(['title'=>str_replace(' ', '-',$this->input('manufacturer')['name']) .'-' . str_replace(' ','-',$this->input('type')['name']).'-'. str_replace(' ','',$this->input('model')['name']) .'-available-for-'. $this->input('offer_for')]);
        }else{
            $this->merge(['title'=>str_replace(' ', '-',$this->input('manufacturer')['name']) .'-' . str_replace(' ','-',$this->input('type')['name']).'-available-for-'. $this->input('offer_for')]);
        }


        $this->merge(['availability'=>Carbon::createFromFormat('d-m-Y',$this->input('availability'))->toDateTimeString()]);
        $apu=new Apu();
        $apu->fill($this->all());
        $apu->user()->associate(auth()->id());
        $apu->category()->associate($this->input('category')['id']);
        $apu->manufacturer()->associate($this->input('manufacturer')['id']);
        $apu->type()->associate($this->input('type')['id']);
        $apu->model()->associate($this->input('model')['id']);
        $apu->contact()->associate($this->input('primary_contact')['id']);
        $apu->currentLocation()->associate($this->input('current_location')['id']);
        if($this->input('custom')){
           foreach ($this->input('custom') as $custom){
               if($custom['name'] =='thrust_rating'){
                   $apu->thrust_rating =$custom['value'];
               }
               if($custom['name']=='lsv_description'){
                   $apu->lsv_description=$custom['value'];
               }
           }
       }
        if($this->input('custom')) {
            foreach ($this->input('custom2') as $custom) {
                if ($custom['label'] == 'owner') {
                    $apu->owner()->associate($custom['value']['id']);
                }
                if ($custom['label'] == 'seller') {
                    $apu->seller()->associate($custom['value']['id']);
                }
            }
        }
        $apu->save();
	    if(count($this->input('images'))>0){
		    foreach ($this->input('images') as $image){
			    $apu->medias()->create([
				    'type'=>$image['type'],
				    'path'=>$image['path'],
				    'original_file_name'=>$image['original_file_name'],
				    'is_featured'=>array_key_exists('is_featured', $image)? $image['is_featured']: false
			    ]);
		    }
	    }

        (new AttachController())->createFile($apu);

        return  $apu;

    }
}
