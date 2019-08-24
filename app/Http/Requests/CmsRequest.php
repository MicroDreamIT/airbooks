<?php

namespace App\Http\Requests;

use App\Cms;
use App\Http\Traits\DropZoneCreate;
use Illuminate\Foundation\Http\FormRequest;

class CmsRequest extends FormRequest
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
            'section' => 'required',
            'url'=>'required',
            'is_active' => 'required'
        ];
    }
    public function createPersist(){
        $cms = Cms::create($this->all());
        $this->createFile($cms);
    }
    public function updatePersist($id)
    {
        $cms=Cms::with('medias')->whereId($id)->first();
        $media=$cms->medias;
        $this->modelOnUpdate($media, $cms);
        $cms->update($this->all());

        return $cms;
    }
}
