<?php

namespace App\Http\Requests;

use App\Airport;
use Illuminate\Foundation\Http\FormRequest;

class AirportRequest extends FormRequest
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
            'name' => 'required|unique_with:airports, name,ignore:'.$this->route('airport'),
            'airfield_type_id' => 'required',
            'city_id' => 'required',
            'iata_code' => 'required',
            'icao_code' => 'required',
            'is_active' => 'required'
        ];
    }

    public function createPersist(){
        $this->merge(['user_id'=> auth()->id()]);
        Airport::create($this->all());
    }
    public function updatePersist($id)
    {
        $this->merge(['user_id'=> auth()->id()]);
        $airport=Airport::find($id);
        $airport->update($this->all());

        return $airport;
    }
}
