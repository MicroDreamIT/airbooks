<?php

namespace App\Http\Requests;

use App\Release;
use Illuminate\Foundation\Http\FormRequest;

class ReleaseRequest extends FormRequest
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
            'name' => 'required|unique_with:releases, name,ignore:'.$this->route('release'),
            'is_active' => 'required',
        ];
    }

    public function createPersist(){

        Release::create($this->all());
    }
    public function updatePersist($id)
    {
        $release=Release::find($id);
        $release->update($this->all());

        return $release;
    }
}
