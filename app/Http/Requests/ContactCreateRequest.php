<?php

namespace App\Http\Requests;

use App\Contact;
use App\Http\Traits\DropZoneCreate;
use Illuminate\Foundation\Http\FormRequest;

class ContactCreateRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'country'=>'required',
        ];
    }

    public function createPersist()
    {
        $contact = $this->createContact(auth()->user());
        return $contact;
    }

    /**
     * @param $user
     * @return Contact
     */
    private function createContact($user)
    {
        $contact = new Contact();
        $contact->fill($this->all());
        $contact->city()->associate($this->input('city')['id']);
        $contact->state()->associate($this->input('state')['id']);
        $contact->country()->associate($this->input('country')['id']);
        $contact->creator()->associate(auth()->id());
        $contact->jobTitle()->associate($this->input('job_title')['id']);
        $contact->department()->associate($this->input('department')['id']);
        $contact->company()->associate($this->input('company')['id']);
        $contact->save();

        $this->createFile($contact);


        return $contact;
    }

    private function createUser()
    {
//        dd($this->user());

        return $this->user()->create([
            'email' => $this->input('email'),
            'password' => bcrypt(str_random(8)),
            'remember_token' => str_random(10)
        ]);

    }


}
