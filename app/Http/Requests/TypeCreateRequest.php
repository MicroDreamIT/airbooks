<?php

namespace App\Http\Requests;

use App\Http\Controllers\MediaController;
use App\Type;
use Illuminate\Foundation\Http\FormRequest;

class TypeCreateRequest extends FormRequest
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
            'manufacturer_id'=>'required',
            'name' => 'required|unique_with:types,type,name,manufacturer_id,ignore:'.$this->route('type'),
            'is_active' => 'required'
        ];
    }

    public function createPersist(){
        $type=Type::create($this->all());
        $this->createFile($type);
    }
    private function createFile($type)
    {

        if($this->input('file')){
            foreach($this->input('file') as $file){
                if(array_key_exists('dataURL', $file)){
                    (new MediaController())->store($type, 'type', $file);
                }
            }
        }

    }
    public function updatePersist($id){

        $type=Type::with('medias')->whereId($id)->first();
        $media = $type->medias;
        if($media && !count($this->input('file')) ){
            $this->removeFile($type, $media);
        }
//        update
        if($media && count($this->input('file'))){
            foreach ($this->input('file') as $file){
                if(array_key_exists('dataURL', $file)){
                    $this->updateFile($type, $media);
                }
            }
        }
        //create
        if(!$media && $this->input('file')){
            $this->createFile($type);
        }

        $type->update($this->except('file','removeFiles'));

        return $type;
    }
    private function updateFile($type, $media)
    {
        foreach ($this->input('removeFiles') as $removeFile){
            $media = $media->whereId($removeFile['contentId'])->first();
            $this->mediaDestroy($media);
            $media->delete();
        }

        $this->createFile($type);

    }

    private function removeFile($type, $media)
    {

        $this->mediaDestroy($media);
        $type->medias->delete();
    }

    /**
     * @param $media
     */
    private function mediaDestroy($media)
    {
        (new MediaController())->destroy($media);
    }
}
