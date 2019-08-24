<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'source',
        'date',
        'details',
        'is_active',
        'views'
    ];

    protected $with=['likes'];

    protected $appends = [
        'modelType', 'linkify'
    ];

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function getModelTypeAttribute()
    {
        return 'news';
    }

    public function getLinkifyAttribute()
    {
        return $this->id.'-'.strtolower(str_replace(' ', '-', $this->title));
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function medias()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function continent(){
        return $this->belongsTo(Continent::class);
    }

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

}
