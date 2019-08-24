<?php

namespace App\Http\Requests;

use App\Airfield;
use Illuminate\Foundation\Http\FormRequest;

class AirfieldRequest extends FormRequest
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
            'name' => 'required|unique_with:airfield_types, name,ignore:'.$this->route('airfield'),
            'is_active' => 'required'
        ];
    }

    public function createPersist(){
        Airfield::create($this->all());
    }
    public function updatePersist($id)
    {
        $airfield=Airfield::find($id);
        $airfield->update($this->all());

        return $airfield;
    }
}
