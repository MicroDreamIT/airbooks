<?php

namespace App\Http\Requests;

use App\Http\Controllers\MediaController;
use App\News;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'title' => 'required|unique_with:news, name,ignore:'.$this->route('news'),
            'categories'=>'required',
            'continent'=>'required',
            'region'=>'required',
            'is_active' => 'required'
        ];
    }

    public function createPersist(){
        $news=new News();
        $this->input('date')?
            $this->merge(['date'=>strpos($this->input('date'), '/')?
                Carbon::parse(Carbon::createFromFormat('d/m/Y', $this->input('date'))):
                Carbon::parse($this->input('date'))]):null;
        $news->fill($this->all());
        $news->company()->associate($this->input('company')['id']);
        $news->continent()->associate($this->input('continent')['id']);
        $news->region()->associate($this->input('region')['id']);
        $news->country()->associate($this->input('country')['id']);
        $news->save();

        $categoryIds=[];
        foreach ($this->input('categories') as $category){
            $categoryIds[]=$category['id'];
        }

        $news->categories()->sync($categoryIds);
        $this->createFile($news);
    }
    private function createFile($news)
    {

        if($this->input('file')){
            foreach($this->input('file') as $file){
                if(array_key_exists('dataURL', $file)){
                    (new MediaController())->store($news, 'news', $file);
                }
            }
        }

    }
    public function updatePersist($id)
    {
        $news=News::with('medias')->whereId($id)->first();
        $media = $news->medias;

        if($media && !count($this->input('file')) ){
            $this->removeFile($news, $media);
        }
//        update
        if($media && count($this->input('file'))){
            foreach ($this->input('file') as $file){
                if(array_key_exists('dataURL', $file)){
                    $this->updateFile($news, $media);
                }
            }
        }

        //create
        if(!$media && $this->input('file')){
            $this->createFile($news);
        }
        $this->input('date')?
            $this->merge(['date'=>strpos($this->input('date'), '/')?
                Carbon::parse(Carbon::createFromFormat('d/m/Y', $this->input('date'))):
                Carbon::parse($this->input('date'))]):null;
        $news->update($this->all());
        $news->company()->associate($this->input('company')['id']);
        $news->continent()->associate($this->input('continent')['id']);
        $news->region()->associate($this->input('region')['id']);
        $news->country()->associate($this->input('country')['id']);
        $news->save();
        $categoryIds=[];
        foreach ($this->input('categories') as $category){
            $categoryIds[]=$category['id'];
        }
        $news->categories()->sync($categoryIds);



        return $news;
    }


    private function updateFile($category, $media)
    {
        foreach ($this->input('removeFiles') as $removeFile){
            $media = $media->whereId($removeFile['contentId'])->first();
            $this->mediaDestroy($media);
            $media->delete();
        }

        $this->createFile($category);

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
