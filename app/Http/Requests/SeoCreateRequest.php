<?php

namespace App\Http\Requests;

use App\Http\Traits\DropZoneCreate;
use App\Seo;
use Illuminate\Foundation\Http\FormRequest;

class SeoCreateRequest extends FormRequest
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
            'title'=>'required',
            'page'=>'required',
            'description'=>'required'
        ];
    }

    public function persist()
    {
        $seo = Seo::create($this->all());
        $this->createFile($seo);
    }

    public function updatePersist($id)
    {
        $category=Seo::with('medias')->whereId($id)->first();
        $media = $category->medias;

        $this->modelOnUpdate($media, $category);
        $category->update($this->all());

        return $category;
    }
}
