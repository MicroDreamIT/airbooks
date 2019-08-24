<?php

namespace App\Http\Requests;

use App\Region;
use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
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
            'name' => 'required|unique_with:regions, name,ignore:'.$this->route('region'),
            'continent_id' => 'required',
            'is_active' => 'required'
        ];
    }
    public function createPersist(){
        Region::create($this->all());
    }
    public function updatePersist($id)
    {
        $region=Region::find($id);
        $region->update($this->all());

        return $region;
    }
}
