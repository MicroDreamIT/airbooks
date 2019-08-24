<?php

namespace App\Http\Requests;

use App\Subscriber;
use Illuminate\Foundation\Http\FormRequest;

class SubscriberRequest extends FormRequest
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
            'name' => 'required|min:3',
            'email' => 'required|email|unique_with:subscribers, email,ignore:'.$this->route('subscriber'),
            'is_active' => 'required'
        ];
    }
    public function createPersist(){
        Subscriber::create($this->all());
    }
    public function updatePersist($id)
    {
        $subscriber=Subscriber::find($id);
        $subscriber->update($this->all());

        return $subscriber;
    }
}
