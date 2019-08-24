<?php

namespace App\Http\Requests;

use App\Cannedemail;
use Illuminate\Foundation\Http\FormRequest;

class CannedemailRequest extends FormRequest
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
            'message_type' => 'required|unique_with:cannedemails, message_type,ignore:'.$this->route('canned_email'),
            'subject' => 'required',
            'sending_email' => 'required|email',
            'is_active' => 'required'
        ];
    }

    public function createPersist(){

        Cannedemail::create($this->all());
    }
    public function updatePersist($id)
    {

        $id->update($this->all());

        return $id;
    }
}
