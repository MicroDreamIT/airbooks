<?php

namespace App\Http\Requests;

use App\Event;
use App\Http\Traits\DropZoneCreate;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required|unique_with:events, title,ignore:'.$this->route('event'),
            'categories' => 'required',
            'continent_id' => 'required',
            'region_id' => 'required',
            'is_active' => 'required',
        ];
    }

    public function createPersist(){
        $this->input('start_date')?
            $this->merge(['start_date'=>strpos($this->input('start_date'), '/')?
                Carbon::parse(Carbon::createFromFormat('d/m/Y', $this->input('start_date'))):
                Carbon::parse($this->input('start_date'))]):null;
        $this->input('end_date')?
            $this->merge(['end_date'=>strpos($this->input('end_date'), '/')?
                Carbon::parse(Carbon::createFromFormat('d/m/Y', $this->input('end_date'))):
                Carbon::parse($this->input('end_date'))]):null;
        $event=Event::create($this->all());
        $categoryIds=[];
        foreach ($this->input('categories') as $category){
            $categoryIds[]=$category['id'];
        }
        $event->categories()->sync($categoryIds);
        $this->createFile($event);
    }

    public function updatePersist($id)
    {
        $this->input('start_date')?
            $this->merge(['start_date'=>strpos($this->input('start_date'), '/')?
                Carbon::parse(Carbon::createFromFormat('d/m/Y', $this->input('start_date'))):
                Carbon::parse($this->input('start_date'))]):null;
        $this->input('end_date')?
            $this->merge(['end_date'=>strpos($this->input('end_date'), '/')?
                Carbon::parse(Carbon::createFromFormat('d/m/Y', $this->input('end_date'))):
                Carbon::parse($this->input('end_date'))]):null;

        $event=Event::with('medias')->whereId($id)->first();
        $media=$event->medias;
        $this->modelOnUpdate($media, $event);
        $event->update($this->all());
        $categoryIds=[];
        foreach ($this->input('categories') as $category){
            $categoryIds[]=$category['id'];
        }
        $event->categories()->sync($categoryIds);
        return $event;

    }
}
