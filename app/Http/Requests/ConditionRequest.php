<?php

namespace App\Http\Requests;

use App\Condition;
use Illuminate\Foundation\Http\FormRequest;

class ConditionRequest extends FormRequest
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
            'name' => 'required|unique_with:conditions, name,ignore:'.$this->route('condition'),
            'is_active' => 'required',
        ];
    }

    public function createPersist(){

        Condition::create($this->all());
    }
    public function updatePersist($id)
    {
        $condition=Condition::find($id);
        $condition->update($this->all());

        return $condition;
    }
}
