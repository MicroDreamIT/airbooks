<?php

namespace App\Http\Requests;

use App\Country;
use App\Http\Traits\DropZoneCreate;
use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    use DropZoneCreate;
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
            'name' => 'required|unique_with:countries, name,ignore:'.$this->route('country'),
            'continent_id' => 'required',
            'region_id' => 'required',
            'iso_3116_alpha_2' => 'nullable|min:2|max:2',
            'is_active' => 'required',
        ];
    }
    public function createPersist(){
        $country=Country::create($this->all());
        $this->createFile($country);
    }
    public function updatePersist($id)
    {
        $country=Country::with('medias')->whereId($id)->first();
        $media=$country->medias;
        $this->modelOnUpdate($media, $country);
        $country->update($this->all());
        return $country;
    }
}
