<?php

namespace App\Http\Requests;

use App\Http\Controllers\MediaController;
use App\Manufacturer;
use Illuminate\Foundation\Http\FormRequest;

class ManufacturerCreateRequest extends FormRequest
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
            'name' => 'required|unique_with:manufacturers,type,name,ignore:'.$this->route('manufacturer'),
            'categories'=>'required',
            'is_active'=>'required',
        ];
    }
    public function createPersist(){

        $manufacturer=Manufacturer::create($this->all());
        $categoryIds=[];
        foreach ($this->input('categories') as $category){
            $categoryIds[]=$category['id'];
        }
        $manufacturer->categories()->sync($categoryIds);
        $this->createFile($manufacturer);
    }
    private function createFile($manufacturer)
    {

        if($this->input('file')){
            foreach($this->input('file') as $file){
                if(array_key_exists('dataURL', $file)){
                    (new MediaController())->store($manufacturer, 'manufacturer', $file);
                }
            }
        }

    }
    public function updatePersist($id)
    {
        $manufacturer=Manufacturer::with('medias')->whereId($id)->first();
        $media = $manufacturer->medias;
        if($media && !count($this->input('file')) ){
            $this->removeFile($manufacturer, $media);
        }
//        update
        if($media && count($this->input('file'))){
            foreach ($this->input('file') as $file){
                if(array_key_exists('dataURL', $file)){
                    $this->updateFile($manufacturer, $media);
                }
            }
        }
        //create
        if(!$media && $this->input('file')){
            $this->createFile($manufacturer);
        }

        $manufacturer->update($this->except('file','removeFiles'));

        $categoryIds=[];
        foreach ($this->input('categories') as $category){
            $categoryIds[]=$category['id'];
        }
        $manufacturer->categories()->sync($categoryIds);

        return $manufacturer;
    }
    private function updateFile($manufacturer, $media)
    {
        foreach ($this->input('removeFiles') as $removeFile){
            $media = $media->whereId($removeFile['contentId'])->first();
            $this->mediaDestroy($media);
            $media->delete();
        }

        $this->createFile($manufacturer);

    }

    private function removeFile($category, $media)
    {

        $this->mediaDestroy($media);
        $category->medias->delete();
    }

    /**
     * @param $media
     */
    private function mediaDestroy($media)
    {
        (new MediaController())->destroy($media);
    }
}
