<?php

namespace App\Http\Requests;

use App\City;
use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
            'name' => 'required|unique_with:cities,name,state_id,ignore:'.$this->route('city'),
            'state_id' => 'required',
            'is_active' => 'required'
        ];
    }
    public function createPersist(){
        City::create($this->all());
    }
    public function updatePersist($id)
    {
        $city=City::find($id);
        $city->update($this->all());

        return $city;
    }
}
