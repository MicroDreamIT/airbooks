<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded=['id','file', 'removeFiles', 'categories'];

    protected $appends = [
        'modelType','linkify', 'hasInterested'
    ];

    protected $with=['likes', 'favourites'];

    public function getModelTypeAttribute()
    {
        return 'events';
    }

    public function getHasInterestedAttribute()
    {

        if(auth()->guest()){
            return false;
        }

        foreach ($this->relations['favourites'] as $interested){
            return $interested->user_id==auth()->id();
        }
    }


    public function getLinkifyAttribute()
    {
        return strtolower($this->id.'-'.str_replace(' ','-',$this->title));
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'visitor');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function continent()
    {
        return $this->belongsTo(Continent::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function medias()
    {
        return $this->morphOne(Media::class, 'mediable');
    }
}
