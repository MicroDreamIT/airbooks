<?php

namespace App\Http\Requests;

use App\Http\SendMail;
use App\Wanted;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class WantedRequest extends FormRequest
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
	public function createPersist(){
        $title = Wanted::latest()->first();
        if (!$title) {
            $uid = 'ABW'.'01';
        }else{
            $uid = 'ABW'. ($title->id + 1);
        }

        $this->merge(['uid'=>$uid]);

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
//		$this->merge(['custom'=>json_encode($this->input('custom'))]);
		$wanted=new Wanted();

		$wanted->fill($this->all());
		$wanted->user()->associate(auth()->id());
        $wanted->manufacturer()->associate($this->input($this->input('type').'Manufacturer')['id']);
        $wanted->typed()->associate($this->input($this->input('type').'Type')['id']);
        $wanted->modeled()->associate($this->input($this->input('type').'Model')['id']);
		$wanted->contact()->associate($this->input('primary_contact')['id']);
		$wanted->country()->associate($this->input('country')['id']);
		$wanted->save();

        (new SendMail())->cannedEmail(auth()->user()->email, auth()->user()->contact->fullName,url(str_slug('wanted/'.$wanted->id.'-'.$wanted->title)),'wanted-asset-publish');



    }
}
