<?php

namespace App\Http\Requests;

use App\Speciality;
use Illuminate\Foundation\Http\FormRequest;

class SpecialityRequest extends FormRequest
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
            'name' => 'required|unique_with:specialities, name,ignore:'.$this->route('speciality'),
            'is_active' => 'required'
        ];
    }

    public function createPersist(){
        Speciality::create($this->all());
    }
    public function updatePersist($id)
    {
        $speciality=Speciality::find($id);
        $speciality->update($this->all());

        return $speciality;
    }

}