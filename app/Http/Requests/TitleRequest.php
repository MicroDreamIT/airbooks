<?php

namespace App\Http\Requests;

use App\Title;
use Illuminate\Foundation\Http\FormRequest;

class TitleRequest extends FormRequest
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
            'name' => 'required|unique_with:titles, name,ignore:'.$this->route('title'),
            'is_active' => 'required'
        ];
    }

    public function createPersist(){
        Title::create($this->all());
    }


    public function updatePersist($id)
    {
        $title=Title::find($id);
        $title->update($this->all());

        return $title;
    }
}
