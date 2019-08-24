<?php

namespace App\Http\Requests;

use App\Engine;
use App\Http\Controllers\AttachController;
use App\Http\GlobalMethods;
use App\Media;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EngineUpdateRequest extends FormRequest
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

    public function updatePersist($id){

        if($this->input('model')){
            $this->merge(['title'=>str_replace(' ', '-',$this->input('manufacturer')['name']) .'-' . str_replace(' ','-',$this->input('type')['name']).'-'. str_replace(' ','-',$this->input('model')['name']) .'-available-for-'. $this->input('offer_for')]);
        }else{
            $this->merge(['title'=>str_replace(' ', '-',$this->input('manufacturer')['name']) .'-' . str_replace(' ','-',$this->input('type')['name']).'-available-for-'. $this->input('offer_for')]);
        }

        $needIsActiveStatusChange=false;
        $this->merge(['availability'=>Carbon::createFromFormat('d-m-Y',$this->input('availability'))->toDateTimeString()]);

        $engine=Engine::whereId($id)->first();

        if($engine->esn != $this->input('esn')){
            $needIsActiveStatusChange=true;
        }
        $engine->fill($this->all());

        if($needIsActiveStatusChange){
            $engine->isActiveStatus='Pending Approval';
        }

        $engine->user()->associate(auth()->id());
        $engine->category()->associate($this->input('category')['id']);
        $engine->manufacturer()->associate($this->input('manufacturer')['id']);
        $engine->type()->associate($this->input('type')['id']);
        $engine->model()->associate($this->input('model')['id']);
        $engine->contact()->associate($this->input('primary_contact')['id']);
        $engine->currentLocation()->associate($this->input('current_location')['id']);
        $tso=$thrust_rating=$lsv_description=null;
        if($this->input('custom')){
            foreach ($this->input('custom') as $custom){
                $custom['name']=='tso'?$tso=$custom['value']:null;
                $custom['name']=='thrust_rating'?$thrust_rating=$custom['value']:null;
                $custom['name']=='lsv_description'?$lsv_description=$custom['value']:null;
            }
        }
        $engine->tso=$tso;
        $engine->thrust_rating=$thrust_rating;
        $engine->lsv_description=$lsv_description;

        $owner=$seller=null;
        if($this->input('custom2')) {
            foreach ($this->input('custom2') as $custom) {
                $custom['name']=='owner'?$owner=$custom['value']['id']:null;
                $custom['name']=='seller'?$seller=$custom['value']['id']:null;
            }
        }
        $engine->owner()->associate($owner);
        $engine->seller()->associate($seller);

        $engine->update();

         if(count($this->input('images'))>0){
             //delete previous image
             (new GlobalMethods())->updateImage($engine);

         }

        (new AttachController())->uploadFile($engine);

        return $engine;
    }



}
