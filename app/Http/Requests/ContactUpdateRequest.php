<?php

namespace App\Http\Requests;

use App\Contact;
use App\Http\Traits\DropZoneCreate;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class ContactUpdateRequest extends FormRequest
{
    use DropZoneCreate;
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country'=>'required',
        ];
    }



    public function updateContact($id)
    {
        $contact =Contact::whereId($id)->first();
        $media=$contact->medias;
        $contact->fill($this->all());
        $contact->city()->associate($this->input('city')['id']);
        $contact->state()->associate($this->input('state')['id']);
        $contact->country()->associate($this->input('country')['id']);
        $contact->jobTitle()->associate($this->input('job_title')['id']);
        $contact->department()->associate($this->input('department')['id']);
        $contact->company()->associate($this->input('company')['id']);
        $contact->save();
        if(!$this->input('requestFrom')=='User'){
            $this->modelOnUpdate($media, $contact);
        }


        return $contact;
    }
}
