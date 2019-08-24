<?php

namespace App\Http\Requests;

use App\Continent;
use Illuminate\Foundation\Http\FormRequest;

class ContinentRequest extends FormRequest
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
            'name' => 'required|unique_with:continents, name,ignore:'.$this->route('continent'),
            'is_active' => 'required'
        ];
    }
    public function createPersist(){
        Continent::create($this->all());
    }
    public function updatePersist($id)
    {
        $continent=Continent::find($id);
        $continent->update($this->all());

        return $continent;
    }
}
