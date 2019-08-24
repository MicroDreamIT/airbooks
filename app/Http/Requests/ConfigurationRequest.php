<?php

namespace App\Http\Requests;

use App\Configuration;
use Illuminate\Foundation\Http\FormRequest;

class ConfigurationRequest extends FormRequest
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
            'name' => 'required|unique_with:configurations, name,ignore:'.$this->route('configuration'),
            'is_active' => 'required',
        ];
    }

    public function createPersist(){

        Configuration::create($this->all());
    }
    public function updatePersist($id)
    {
        $configuration=Configuration::find($id);
        $configuration->update($this->all());

        return $configuration;
    }
}
