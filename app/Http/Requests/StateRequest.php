<?php

namespace App\Http\Requests;

use App\State;
use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
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
            'name' => 'required|unique_with:states,name,country_id,ignore:'.$this->route('state'),
            'country_id' => 'required',
            'is_active' => 'required'
        ];
    }
    public function createPersist(){
        State::create($this->all());
    }
    public function updatePersist($id)
    {
        $state=State::find($id);
        $state->update($this->all());

        return $state;
    }
}
