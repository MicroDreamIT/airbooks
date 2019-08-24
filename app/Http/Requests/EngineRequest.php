<?php

namespace App\Http\Requests;

use App\Engine;
use App\Http\Controllers\AttachController;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EngineRequest extends FormRequest
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
            'esn' => 'required|unique_with:engines, name,ignore:'.$this->route('engine'),
            'category'=>'required',
            'manufacturer'=>'required',
            'type'=>'required',
            'status'=>'required',
            'primary_contact'=>'required',
            'offer_for'=>'required',
            'availability'=>'required',
        ];
    }

    public function createPersist(){
        $title = Engine::latest()->first();

        if (!$title) {
            $uid = 'ABE'.'01';
        }else{
            $uid = 'ABE'. ($title->id + 1);
        }

        $this->merge(['uid'=>$uid]);
        if($this->is_featured){
            $this->merge(['promotion_date'=>Carbon::now()]);
        }
        if($this->input('model')){
            $this->merge(['title'=>str_replace(' ', '-',$this->input('manufacturer')['name']) .'-' . str_replace(' ','-',$this->input('type')['name']).'-'. str_replace(' ','-',$this->input('model')['name']) .'-available-for-'. $this->input('offer_for')]);
        }else{
            $this->merge(['title'=>str_replace(' ', '-',$this->input('manufacturer')['name']) .'-' . str_replace(' ','-',$this->input('type')['name']).'-available-for-'. $this->input('offer_for')]);
        }


        $this->merge(['availability'=>Carbon::createFromFormat('d-m-Y',$this->input('availability'))->toDateTimeString()]);
        $engine=new Engine();
        $engine->fill($this->all());
        $engine->user()->associate(auth()->id());
        $engine->category()->associate($this->input('category')['id']);
        $engine->manufacturer()->associate($this->input('manufacturer')['id']);
        $engine->type()->associate($this->input('type')['id']);
        $engine->model()->associate($this->input('model')['id']);
        $engine->contact()->associate($this->input('primary_contact')['id']);
        $engine->currentLocation()->associate($this->input('current_location')['id']);

       if($this->input('custom')){
           foreach ($this->input('custom') as $custom){
               if($custom['name']=='tso'){
                   $engine->tso=$custom['value'];
               }
               if($custom['name'] =='thrust_rating'){
                   $engine->thrust_rating =$custom['value'];
               }
               if($custom['name']=='lsv_description'){
                   $engine->lsv_description=$custom['value'];
               }
           }
       }

        if($this->input('custom2')) {
            foreach ($this->input('custom2') as $custom) {
                if ($custom['name'] == 'owner') {
                    $engine->owner()->associate($custom['value']['id']);
                }
                if ($custom['name'] == 'seller') {
                    $engine->seller()->associate($custom['value']['id']);
                }
            }
        }

        $engine->save();
	
	    if(count($this->input('images'))>0){

		    foreach ($this->input('images') as $image){
			    $engine->medias()->create([
				    'type'=>$image['type'],
				    'path'=>$image['path'],
				    'original_file_name'=>$image['original_file_name'],
				     'is_featured'=>array_key_exists('is_featured', $image)? $image['is_featured']: false
			    ]);
		    }

	    }

        (new AttachController())->createFile($engine);

	    return $engine;
    }
}
