<?php

namespace App\Http\Requests;


use App\Http\Controllers\MediaController;
use App\Modeled;
use Illuminate\Foundation\Http\FormRequest;

class ModelCreateRequest extends FormRequest
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
            'type_id'=>'required',
            'name' => 'required|unique_with:models,type,name,type_id,ignore:'.$this->route('model'),

        ];
    }


    public function createPersist(){
        $model=Modeled::create($this->all());
        $this->createFile($model);
    }
    private function createFile($model)
    {
        if($this->input('file')){
            foreach($this->input('file') as $file){
                if(array_key_exists('dataURL', $file)){
                    (new MediaController())->store($model, 'model', $file);
                }
            }
        }

    }
    public function updatePersist($id){

        $model=Modeled::with('medias')->whereId($id)->first();
        $media = $model->medias;
        if($media && !count($this->input('file')) ){
            $this->removeFile($model, $media);
        }
//        update
        if($media && count($this->input('file'))){
            foreach ($this->input('file') as $file){
                if(array_key_exists('dataURL', $file)){
                    $this->updateFile($model, $media);
                }
            }
        }
        //create
        if(!$media && $this->input('file')){
            $this->createFile($model);
        }

        $model->update($this->except('file','removeFiles'));

        return $model;
    }
    private function updateFile($model, $media)
    {
        foreach ($this->input('removeFiles') as $removeFile){
            $media = $media->whereId($removeFile['contentId'])->first();
            $this->mediaDestroy($media);
            $media->delete();
        }

        $this->createFile($model);

    }

    private function removeFile($model, $media)
    {

        $this->mediaDestroy($media);
        $model->medias->delete();
    }

    /**
     * @param $media
     */
    private function mediaDestroy($media)
    {
        (new MediaController())->destroy($media);
    }
}
