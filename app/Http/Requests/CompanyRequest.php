<?php

namespace App\Http\Requests;

use App\Company;
use App\Http\Traits\DropZoneCreate;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' => 'required|unique_with:companies,name,ignore:'.$this->route('company'),
            'speciality_id'=>'required',
            'profile'=>'max:1000|nullable',
            'is_active' => 'required'
        ];
    }

    public function createPersist(){

        $company= Company::create($this->except('speciality_id'));
        $specialityIds=[];
        foreach ($this->input('speciality_id') as $speciality){
            $specialityIds[]=$speciality['id'];
        }
        $company->specialities()->sync($specialityIds);

        $this->createFile($company);



    }
    public function updatePersist($id)
    {
        $company=Company::with('medias')->whereId($id)->first();
        $media=$company->medias;
        $specialityIds=[];
        foreach ($this->input('speciality_id') as $speciality){
            $specialityIds[]=$speciality['id'];
        }

        $this->modelOnUpdate($media, $company);
        $company->specialities()->sync($specialityIds);
        $company->update($this->except('speciality_id', 'specialities'));

        return $company;

    }
}
