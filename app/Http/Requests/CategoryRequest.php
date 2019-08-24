<?php

namespace App\Http\Requests;

use App\Category;
use App\Http\Controllers\MediaController;
use App\Http\Traits\DropZoneCreate;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|unique_with:categories,type,name,ignore:'.$this->route('category'),
            'is_active' => 'required'
        ];
    }

    public function createPersist()
    {
        $category = Category::create($this->all());
        $this->createFile($category);
    }


    public function updatePersist($id)
    {

        $category=Category::with('medias')->whereId($id)->first();
        $media = $category->medias;

        $this->modelOnUpdate($media, $category);
        $category->update($this->all());

        return $category;
    }

}
